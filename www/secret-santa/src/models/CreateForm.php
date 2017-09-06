<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * CreateForm
 */
class CreateForm extends Model
{
    /** @var array $emails */
    public $emails;
    /** @var string $message */
    public $message;

    protected $members;
    protected $relations;
    protected $draw;

    private $data;
    const CHECKWORDS_KEY = 'CHECKWORDS';


    public function make()
    {
        // создадим участников жеребьевки
        if (!$this->hasErrors()) {
            $this->setMembers();
        }
        // создадим саму сущность жеребьевки
        if (!$this->hasErrors()) {
            $this->setDraw();
        }
        // произведм жеребьевку и свяжем участников друг с другом
        if (!$this->hasErrors()) {
            $this->setRelations();
        }

        // отправим письма всем участникам, если жеребьевка прошла успешно
        if (!$this->hasErrors()) {
            $this->send();
            $this->sendForAdmin();
        }
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['emails', 'message'], 'required'],
            [['message'], 'string', 'max' => 1000],
            ['emails', function ($attribute, $params) {
                if (is_array($this->$attribute) && count($this->$attribute) >= \app\models\Member::MIN_COUNT && count($this->$attribute) <= \app\models\Member::MAX_COUNT) {
                    foreach ($this->$attribute as $email) {
                        if (!Member::validateEmail($email)) {
                            $this->addError('param_error', 'Некорректные входящие параметры');
                            \Yii::error(['Передан некорректный email', $email]);
                            break;
                        }
                    }
                }
                else {
                    $this->addError('param_error', 'Некорректные входящие параметры');
                    \Yii::error(['Переданы некорректные входящие параметры', $this->$attribute]);
                }
            }]
        ];
    }

    public function prepare()
    {
        if ($this->message && !empty($this->message)) {
            $this->message = strip_tags($this->message);
        }

        if ($this->emails && is_array($this->emails)) {
            $this->emails = array_filter($this->emails, function($value) { return $value !== ''; });
            $this->emails = array_unique($this->emails);
        }
    }


    /**
     * key - Giver
     * value - Getter
     * @return array
     */
    protected function buildCouples()
    {
        $result = [];

        // Вариант 1
        // для каждого участника формируем временный массив
        // из которого удаляем его самого и всех ранее занятых участников
        // upd: имеем проблемы с зеркальными парами (А-В и В-А)
        // и проблему нехватки участника для составлении пары, когда участников нечетное кол-во
        /*for ($i = 0; $i < count($this->emails); $i++) {
            $arr = $this->emails;
            unset($arr[$i]);
            $arr = array_diff($arr, array_values($result));
            $j = array_rand($arr, 1);
            $result[$this->emails[$i]] = $this->emails[$j];
        }*/

        // Вариант 2
        // сортируем массив участников случайным образом
        // каждый участник берет в пару следующего
        // последний участник берет в пару первого
        shuffle($this->emails);
        $cnt = count($this->emails);
        for ($i = 0; $i < $cnt; $i++) {
            $j = ($i < ($cnt - 1)) ? ($i + 1) : 0;
            $result[$this->emails[$i]] = $this->emails[$j];
        }

        return $result;
    }

    protected function setMembers()
    {
        foreach ($this->emails as $email) {
            $member = Member::getByEmail($email);
            if (!$member) {
                $member = new Member();
                $member->email = $email;
                if ($member->validate()) {
                    if (!$member->save()) {
                        $this->addError('db_error', 'Не удалось сохранить данные участников');
                        \Yii::error(['Не удалось сохранить данные участника в БД', $email]);
                        break;
                    }
                }
                else {
                    $this->addError('validation_error', 'Некорректные данные участников');
                    \Yii::error(['Некорректные данные для участника', $email]);
                    break;
                }
            }
            $member->checkword = Member::generateCheckword();
            $this->data[self::CHECKWORDS_KEY][$member->email] = $member->checkword;
            $this->members[$email] = $member;
        }
    }

    protected function setDraw()
    {
        $this->draw = new Draw();
        $this->draw->date = date("Y-m-d H:i:s");
        $this->draw->secret = Draw::makeSecret(array_values($this->data[self::CHECKWORDS_KEY]));
        $this->draw->message = $this->message;
        $this->draw->info = substr(json_encode($this->getClientInfo()), 0, 999);

        if ($this->draw->validate()) {
            if (!$this->draw->save()) {
                $this->addError('db_error', 'Не удалось сохранить данные жеребьевки');
                \Yii::error(['Не удалось сохранить данные жеребьевки в БД']);
            }
        }
        else {
            $this->addError('validation_error', 'Некорректные данные жеребьевки');
            \Yii::error(['Некорректные данные жеребьевки']);
        }
    }

    /**
     * @return array
     */
    protected function getClientInfo() {
        $info = [];
        $info['IP'] = \Yii::$app->request->userIP;
        $info['HOST'] = \Yii::$app->request->userHost;
        $info['BROWSER'] = \Yii::$app->request->userAgent;
        $info['REFERRER'] = \Yii::$app->request->referrer;
        return $info;
    }

    protected function setRelations()
    {
        $couples = $this->buildCouples();
        foreach ($couples as $key => $value) {
            $relation = new Relation();
            $relation->giver_id = $this->members[$key]->id;
            $relation->getter_id = $this->members[$value]->id;
            $relation->draw_id = $this->draw->id;

            if ($relation->validate()) {
                if ($relation->save()) {
                    $this->relations[] = $relation;
                }
                else {
                    $this->addError('db_error', 'Не удалось сохранить данные о связях участников');
                    \Yii::error(['Не удалось сохранить данные о связях участников в БД']);
                    break;
                }
            }
            else {
                $this->addError('validation_error', 'Некорректные данные о связях участников');
                \Yii::error(['Некорректные данные о связях участников']);
                break;
            }
        }
    }

    protected function send()
    {
        /** @var Relation $relation */
        foreach ($this->relations as $relation) {
            /** @var Member $giver */
            $giver = $relation->getGiver()->one();
            /** @var Member $getter */
            $getter = $relation->getGetter()->one();

            $recipient = $giver->email;
            $subject = 'Ты попал в лапы тайного Cанты.';
            $message = $this->draw->message;

            $valid = Yii::$app->mailer->compose([
                    'html' => 'add-member-html',
                    'text' => 'add-member-text'
                ], [
                    'MESSAGE' => $message,
                    'DRAW_ID' => $this->draw->id,
                    'CHECKWORD' => $this->data[self::CHECKWORDS_KEY][$giver->email],
                    'GETTER' => $getter->email
                ])
                ->setTo($recipient)
                ->setSubject($subject)
                //->setFrom([self::MAIL_SENDER])
                //->setTextBody($message)
                ->send();

            if (!$valid) {
                $this->addError('smtp_error', 'Не удалось отправить письмо');
                \Yii::error(['Не удалось отправить сообщение', $giver->email]);
                break;
            }
            else {
                \Yii::info(['Отправлено сообщение', $giver->email]);
            }
        }
    }

    protected function sendForAdmin()
    {
        $recipients = \Yii::$app->params['drawEmails'];
        $subject = 'Новая жеребьевка.';
        $message = '';
        if ($recipients && $recipients != '') {
            $valid = Yii::$app->mailer->compose([
                'html' => 'new-draw-html'
            ], [
                'MESSAGE' => $message
            ])
                ->setTo($recipients)
                ->setSubject($subject)
                //->setTextBody($message)
                ->send();

            if (!$valid) {
                \Yii::warning(['Не удалось отправить информацию о новой жеребьевке', $recipients]);
            }
        }
    }

}
