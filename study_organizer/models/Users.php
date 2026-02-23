<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Users".
 *
 * @property int $U_ID
 * @property string $U_username
 * @property string $U_password
 * @property string $U_role
 */
class Users extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['U_username', 'U_password', 'U_role'], 'required'],
            [['U_username', 'U_password', 'U_role'], 'string', 'max' => 255],
            [['U_username'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'U_ID' => Yii::t('app', 'U ID'),
            'U_username' => Yii::t('app', 'U Username'),
            'U_password' => Yii::t('app', 'U Password'),
            'U_role' => Yii::t('app', 'U Role'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return UsersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsersQuery(get_called_class());
    }

}
