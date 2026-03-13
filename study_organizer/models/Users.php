<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "Users".
 *
 * @property int $U_ID
 * @property string $U_username
 * @property string $U_password
 * @property string $U_role
 */
class Users extends \yii\db\ActiveRecord implements IdentityInterface
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

    public function beforeValidate()
    {
        if (!$this->isNewRecord && ($this->U_password === '' || $this->U_password === null)) {
            $this->U_password = $this->getOldAttribute('U_password');
        }

        return parent::beforeValidate();
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($this->U_password !== null && $this->U_password !== '' && !$this->isPasswordHash($this->U_password)) {
            $this->U_password = Yii::$app->security->generatePasswordHash($this->U_password);
        }

        return true;
    }

    public static function findIdentity($id)
    {
        return static::findOne(['U_ID' => $id]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('findIdentityByAccessToken is not implemented.');
    }

    public static function findByUsername($username)
    {
        return static::findOne(['U_username' => $username]);
    }

    public function getId()
    {
        return $this->U_ID;
    }

    public function getUsername()
    {
        return $this->U_username;
    }

    public function getAuthKey()
    {
        return null;
    }

    public function validateAuthKey($authKey)
    {
        return false;
    }

    public function validatePassword($password)
    {
        if ($this->U_password === null) {
            return false;
        }

        if ($this->isPasswordHash($this->U_password)) {
            return Yii::$app->security->validatePassword($password, $this->U_password);
        }

        return hash_equals($this->U_password, $password);
    }

    private function isPasswordHash($value)
    {
        return preg_match('/^\\$(2y|2a|argon2i|argon2id)\\$/', $value) === 1;
    }

}
