<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 *
 * @property File $signatureFile
 */
class BaseUser extends ActiveRecord implements IdentityInterface
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 10;

    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public static function instantiate($row)
    {
        switch ($row['user_type']) {
            case UserType::ROLE_ADMIN:
                return new Administrator();
            case UserType::ROLE_USER:
                return new User();
            default:
               return new self;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'timestampBehavior' => TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getSignatureFile()
    {
        return $this->hasOne(File::class, ['id' => 'signature_file_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['user_type', 'number'],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Set the status of user to active
     * @return void
     */
    public function activate()
    {
        $this->status = self::STATUS_ACTIVE;
    }

    /**
     * Returns the name of status
     * @return string
     */
    public function getStatusName()
    {
        $statuses = self::getStatuses();

        return $this->status !== null && isset($statuses[$this->status])
            ? $statuses[$this->status]
            : '';
    }

    /**
     * Returns the array of genders
     * @return array
     */
    public static function getGenders()
    {
        return [
            self::GENDER_MALE => Yii::t('common', 'Male'),
            self::GENDER_FEMALE => Yii::t('common', 'Female'),
        ];
    }

    /**
     * Returns the array of statuses
     * @return array
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_ACTIVE => Yii::t('common', 'Active'),
            self::STATUS_INACTIVE => Yii::t('common', 'Inactive'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserType()
    {
        return $this->hasOne(UserType::className(), ['id' => 'user_type']);
    }

    /**
     * Returns if the user has assigned with the provided user type
     * @param  \common\models\UserType|integer  $user_type the user type model or id
     * @return boolean
     */
    public function hasUserType($user_type)
    {
        if ($user_type instanceOf UserType) {
            return $this->getUserType()->andWhere(['id' => $user_type->id])->exists();
        } else if (is_int($user_type)) {
            return $this->getUserType()->andWhere(['id' => $user_type])->exists();
        } else {
            return false;
        }
    }

    /**
     * Returns whether the user status is active
     * @return boolean
     */
    public function isActive()
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    /**
     * Returns whether the user status is inactive
     * @return boolean
     */
    public function isInactive()
    {
        return $this->status == self::STATUS_INACTIVE;
    }

    /**
     * Returns whether the user is admin or not
     * @return boolean
     */
    public function isAdmin()
    {
        return $this->user_type == UserType::ROLE_ADMIN;
    }

    /**
     * Personates this model to the provided model
     * @param  mixed $class_name subclass of user model (\common\models\User).
     * @return mixed
     */
    public function personateAs($class_name)
    {
        $model = new $class_name;
        $model->isNewRecord = false;

        foreach ($this->attributes as $attribute_name =>  $attribute_value) {
            if ($model->hasAttribute($attribute_name)) {
                $model->setAttribute($attribute_name, $attribute_value);
            }
        }

        $model->refresh();

        return $model;
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes )
    {
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @inheritdoc
     * @return \common\models\query\UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\UserQuery(get_called_class());
    }
}
