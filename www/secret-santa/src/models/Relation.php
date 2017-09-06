<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Relation".
 *
 * @property integer $id
 * @property integer $giver_id
 * @property integer $getter_id
 * @property integer $draw_id
 *
 * @property Draw $draw
 * @property Member $giver
 * @property Member $getter
 */
class Relation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Relation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['giver_id', 'getter_id', 'draw_id'], 'required'],
            [['giver_id', 'getter_id', 'draw_id'], 'integer'],
            [['draw_id'], 'exist', 'skipOnError' => true, 'targetClass' => Draw::className(), 'targetAttribute' => ['draw_id' => 'id']],
            [['giver_id'], 'exist', 'skipOnError' => true, 'targetClass' => Member::className(), 'targetAttribute' => ['giver_id' => 'id']],
            [['getter_id'], 'exist', 'skipOnError' => true, 'targetClass' => Member::className(), 'targetAttribute' => ['getter_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'giver_id' => 'Giver ID',
            'getter_id' => 'Getter ID',
            'draw_id' => 'Draw ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDraw()
    {
        return $this->hasOne(Draw::className(), ['id' => 'draw_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGiver()
    {
        return $this->hasOne(Member::className(), ['id' => 'giver_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGetter()
    {
        return $this->hasOne(Member::className(), ['id' => 'getter_id']);
    }
}
