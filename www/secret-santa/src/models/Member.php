<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Member".
 *
 * @property integer $id
 * @property string $email
 * @property string $checkword
 *
 * @property Relation[] $relations
 * @property Relation[] $relations0
 */
class Member extends \yii\db\ActiveRecord
{
    const MIN_COUNT = 3;
    const MAX_COUNT = 150;

    const CHECKWORD_LENGTH = 5;
    const CHECKWORD_PATTERN = 'abdefghijkmnpqrstuwxyzABDEFGHIJKLMNPQRSTUWXYZ123456789';

    /**
     * @var string
     */
    public $checkword;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Member';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            [['email'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGiver()
    {
        return $this->hasMany(Relation::className(), ['giver_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGetter()
    {
        return $this->hasMany(Relation::className(), ['getter_id' => 'id']);
    }


    /**
     * @param $email
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function getByEmail($email)
    {
        return self::find()->where(['email' => $email])->one();
    }

    /**
     * Validates email
     *
     * @param string $email email to validate
     * @return bool
     */
    public static function validateEmail($email)
    {
        $validator = new \yii\validators\EmailValidator();
        return !empty($email) && $validator->validate($email);
        //return !empty($email) && preg_match('/^([a-zA-Z0-9_-]+\.)*[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)*\.[a-zA-Z]{2,6}$/i', $email);
    }

    /**
     * Validates checkword
     *
     * @param string $checkword checkword to validate
     * @return bool
     */
    public static function validateCheckword($checkword)
    {
        $pattern = '/^['.self::CHECKWORD_PATTERN.']{'.self::CHECKWORD_LENGTH.'}$/i';
        return !empty($checkword) && preg_match($pattern, $checkword);
    }

    /**
     * Generate checkword for member
     *
     * @return string
     */
    public static function generateCheckword()
    {
        $checkword = '';
        $pattern = self::CHECKWORD_PATTERN;
        $length = self::CHECKWORD_LENGTH;

        for ($i = 0; $i < $length; $i++) {
            $key = rand(0, strlen($pattern) - 1);
            $checkword .= $pattern[$key];
        }

        return $checkword;
    }

}
