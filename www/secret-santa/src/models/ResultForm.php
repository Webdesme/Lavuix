<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\Query;

/**
 * ResultForm
 */
class ResultForm extends Model
{
    /** @var array $checkwords */
    public $checkwords;

    /**
     * @var array $couples
     * key - Giver
     * value - Getter
     */
    public $couples;

    /**
     * @var int $draw_id
     */
    public $draw_id;

    /** @var string $secret */
    protected $secret;


    public function make()
    {
        if (!$this->hasErrors()) {
            // получим данные из бд и восстановим пары между участниками
            $this->getCouples();
        }
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['checkwords'], 'required'],
            ['checkwords', function ($attribute, $params) {
                if (is_array($this->$attribute) && count($this->$attribute) >= Member::MIN_COUNT && count($this->$attribute) <= Member::MAX_COUNT) {
                    foreach ($this->$attribute as $checkword) {
                        if (!Member::validateCheckword($checkword)) {
                            $this->addError('param_error', 'Переданы некорректные входящие параметры');
                            \Yii::error(['Передано некорректное проверочное слово', $checkword]);
                            break;
                        }
                    }
                }
                else {
                    $this->addError('param_error', 'Переданы некорректные входящие параметры');
                    \Yii::error(['Переданы некорректные входящие параметры', $this->$attribute]);
                }
            }]
        ];
    }

    public function prepare()
    {
        if ($this->checkwords && is_array($this->checkwords)) {
            $this->checkwords = array_filter($this->checkwords, function($value) { return $value !== ''; });
            //$this->checkwords = array_unique($this->checkwords);
        }
    }


    protected function getCouples()
    {
        $this->couples = [];
        $this->secret = Draw::makeSecret($this->checkwords);
        if (!empty($this->secret)) {
            $limit = Member::MAX_COUNT;
            $rows = (new Query())
                ->select([
                    'Getter.email AS getter',
                    'Giver.email AS giver',
                    'Draw.id AS draw_id'
                ])
                ->from('Draw')
                ->innerJoin('Relation', 'Relation.draw_id = Draw.id')
                ->innerJoin('Member AS Getter', 'Getter.id = Relation.getter_id')
                ->innerJoin('Member AS Giver', 'Giver.id = Relation.giver_id')
                ->where(['secret' => $this->secret])
                ->limit($limit)
                ->all();

            if (!empty($rows)) {
                foreach ($rows as $row) {
                    $this->couples[$row['giver']] = $row['getter'];
                    $this->draw_id = $row['draw_id'];
                }
            }
            else {
                $this->addError('empty_result', 'Результаты отсутствуют');
                \Yii::warning(['Результаты отсутствуют', $this->secret]);
            }

        }
    }

}
