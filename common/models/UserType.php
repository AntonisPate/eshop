<?php

namespace common\models;

use Yii;
use backend\models\TranslationFactory;

/**
 * This is the model class for table "{{%user_type}}".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 */
class UserType extends \yii\db\ActiveRecord
{
    const ROLE_ADMIN = 1;
    const ROLE_USER = 0;

    const ROLE_PREFIX = 'user_type_';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_type}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 5000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
        ];
    }

    /**
     * Return the rbac auth role name for this model.
     * The role name is self::ROLE_PREFIX_id, user_type_[id]
     * @return string
     */
    public function getAuthRoleName()
    {
        return self::ROLE_PREFIX . $this->id;
    }


    /**
     * Returns an array with id and the description of roles
     * @return array
     */
    public static function getTypes()
    {
        $translatorFactory = new TranslationFactory();
        $translator = $translatorFactory->translator;
        return [
            self::ROLE_ADMIN => $translator->translate('Administrator'),
            self::ROLE_USER => $translator->translate('User'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $this->saveUserTypeAuthRole(); // create (if not exist) user type rbac auth role
    }

    /**
     * Creates (if not alread exists) a rbac auth item role for user type,
     * the auth item identifier is the model's id prepended by self::ROLE_PREFIX ('user_group_')
     * @return void
     */
    protected function saveUserTypeAuthRole()
    {
        // $auth = Yii::$app->authManager;

        // // check if the auth role exists
        // if (!$auth->getRole($this->getAuthRoleName())) {
        //     $user_group_role = $auth->createRole($this->getAuthRoleName()); // if the auth role does not exist create it
        //     $auth->add($user_group_role); //add role to auth manager
        // }
    }



    /**
     * {@inheritdoc}
     * @return \common\models\query\UserTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\UserTypeQuery(get_called_class());
    }
}
