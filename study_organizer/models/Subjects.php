<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Subjects".
 *
 * @property int $S_ID
 * @property string $S_name
 * @property int $S_T_ID
 *
 * @property Homework[] $homeworks
 * @property Teacher $sT
 */
class Subjects extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Subjects';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['S_name', 'S_T_ID'], 'required'],
            [['S_T_ID'], 'integer'],
            [['S_name'], 'string', 'max' => 255],
            [['S_name'], 'unique'],
            [['S_T_ID'], 'exist', 'skipOnError' => true, 'targetClass' => Teacher::class, 'targetAttribute' => ['S_T_ID' => 'T_ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'S_ID' => Yii::t('app', 'S ID'),
            'S_name' => Yii::t('app', 'S Name'),
            'S_T_ID' => Yii::t('app', 'S T ID'),
        ];
    }

    /**
     * Gets query for [[Homeworks]].
     *
     * @return \yii\db\ActiveQuery|HomeworkQuery
     */
    public function getHomeworks()
    {
        return $this->hasMany(Homework::class, ['H_S_ID' => 'S_ID']);
    }

    /**
     * Gets query for [[ST]].
     *
     * @return \yii\db\ActiveQuery|TeacherQuery
     */
    public function getST()
    {
        return $this->hasOne(Teacher::class, ['T_ID' => 'S_T_ID']);
    }

    /**
     * {@inheritdoc}
     * @return SubjectsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SubjectsQuery(get_called_class());
    }

}
