<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Teachers".
 *
 * @property int $T_ID
 * @property string $T_name
 * @property int $T_is_active
 *
 * @property Subject[] $subjects
 */
class Teachers extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Teachers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['T_is_active'], 'default', 'value' => 1],
            [['T_name'], 'required'],
            [['T_is_active'], 'integer'],
            [['T_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'T_ID' => Yii::t('app', 'ID'),
            'T_name' => Yii::t('app', 'Name'),
            'T_is_active' => Yii::t('app', 'Active'),
        ];
    }

    /**
     * Gets query for [[Subjects]].
     *
     * @return \yii\db\ActiveQuery|SubjectsQuery
     */
    public function getSubjects()
    {
        return $this->hasMany(Subjects::class, ['S_T_ID' => 'T_ID']);
    }

    /**
     * {@inheritdoc}
     * @return TeachersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TeachersQuery(get_called_class());
    }

}
