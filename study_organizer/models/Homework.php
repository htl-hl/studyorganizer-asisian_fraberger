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
 * @property int $H_U_ID
 *
 * @property Subjects $hS
 * @property Users $owner
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
            [['H_title', 'H_due_date', 'H_S_ID', 'H_U_ID'], 'required'],
            [['H_description'], 'string'],
            [['H_due_date'], 'safe'],
            [['H_is_done', 'H_S_ID', 'H_U_ID'], 'integer'],
            [['H_title'], 'string', 'max' => 255],
            [['H_S_ID'], 'exist', 'skipOnError' => true, 'targetClass' => Subjects::class, 'targetAttribute' => ['H_S_ID' => 'S_ID']],
            [['H_U_ID'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['H_U_ID' => 'U_ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'H_ID' => Yii::t('app', 'ID'),
            'H_title' => Yii::t('app', 'Title'),
            'H_description' => Yii::t('app', 'Description'),
            'H_due_date' => Yii::t('app', 'Due date'),
            'H_is_done' => Yii::t('app', 'Completed'),
            'H_S_ID' => Yii::t('app', 'Subject'),
            'H_U_ID' => Yii::t('app', 'Owner'),
        ];
    }

    /**
     * Gets query for [[HS]].
     *
     * @return \yii\db\ActiveQuery|SubjectsQuery
     */
    public function getHS()
    {
        return $this->getSubject();
    }

    public function getSubject()
    {
        return $this->hasOne(Subjects::class, ['S_ID' => 'H_S_ID']);
    }

    public function getOwner()
    {
        return $this->hasOne(Users::class, ['U_ID' => 'H_U_ID']);
    }

    /**
     * {@inheritdoc}
     * @return HomeworkQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new HomeworkQuery(get_called_class());
    }

    public function isDone()
    {
        return (int) $this->H_is_done === 1;
    }

    public function isEditable()
    {
        return !$this->isDone();
    }

    public function getDueCssClass()
    {
        $secondsUntilDue = strtotime($this->H_due_date . ' 00:00:00') - strtotime('today');

        if ($secondsUntilDue <= 86400) {
            return 'due-red';
        }

        if ($secondsUntilDue < 604800) {
            return 'due-yellow';
        }

        if ($secondsUntilDue < 1209600) {
            return 'due-blue';
        }

        return 'due-none';
    }

    public function getDueRowClass()
    {
        if ($this->isDone()) {
            return 'task-locked';
        }

        if ($this->getDueCssClass() === 'due-red') {
            return 'task-due-red';
        }

        if ($this->getDueCssClass() === 'due-yellow') {
            return 'task-due-yellow';
        }

        if ($this->getDueCssClass() === 'due-blue') {
            return 'task-due-blue';
        }

        return '';
    }

}
