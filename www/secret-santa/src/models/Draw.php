<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Draw".
 *
 * @property integer $id
 * @property string $date
 * @property string $secret
 * @property string $message
 * @property string $info
 *
 * @property Relation[] $relations
 */
class Draw extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Draw';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'secret'], 'required'],
            [['date'], 'safe'],
            [['secret'], 'string', 'max' => 35],
            [['message', 'info'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'secret' => 'Secret',
            'message' => 'Message',
            'info' => 'Info',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDraw()
    {
        return $this->hasMany(Relation::className(), ['draw_id' => 'id']);
    }

    /**
     * Make secret for checkwords array
     *
     * @param array $checkwords
     * @return string
     */
    public static function makeSecret(array $checkwords)
    {
        $secret = null;
        $separator = '-';
        if (!empty($checkwords)) {
            //отсортируем по алфавиту без учета регистра
            sort($checkwords, SORT_STRING | SORT_FLAG_CASE);
            //объеденим массив в строку и получим от нее md5-хеш
            $secret = md5(implode($separator, $checkwords));
        }
        return $secret;
    }
}
