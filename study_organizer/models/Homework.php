<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Homework".
 *
 * @property int $H_ID
 * @property string $H_title
 * @property string|null $H_description
 * @property string $H_due_date
 * @property int $H_is_done
 * @property int $H_S_ID
 *
 * @property Subject $hS
 */
class Homework extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Homework';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['H_description'], 'default', 'value' => null],
            [['H_is_done'], 'default', 'value' => 0],
            [['H_title', 'H_due_date', 'H_S_ID'], 'required'],
            [['H_description'], 'string'],
            [['H_due_date'], 'safe'],
            [['H_is_done', 'H_S_ID'], 'integer'],
            [['H_title'], 'string', 'max' => 255],
            [['H_S_ID'], 'exist', 'skipOnError' => true, 'targetClass' => Subject::class, 'targetAttribute' => ['H_S_ID' => 'S_ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'H_ID' => Yii::t('app', 'H ID'),
            'H_title' => Yii::t('app', 'H Title'),
            'H_description' => Yii::t('app', 'H Description'),
            'H_due_date' => Yii::t('app', 'H Due Date'),
            'H_is_done' => Yii::t('app', 'H Is Done'),
            'H_S_ID' => Yii::t('app', 'H S ID'),
        ];
    }

    /**
     * Gets query for [[HS]].
     *
     * @return \yii\db\ActiveQuery|SubjectQuery
     */
    public function getHS()
    {
        return $this->hasOne(Subject::class, ['S_ID' => 'H_S_ID']);
    }

    /**
     * {@inheritdoc}
     * @return HomeworkQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new HomeworkQuery(get_called_class());
    }

}
