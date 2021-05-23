<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user".
 */
class Administrator extends BaseUser
{

    public function init()
    {
        $this->user_type = UserType::ROLE_ADMIN;
        parent::init();
    }

    public function beforeSave($insert)
    {
        $this->user_type = UserType::ROLE_ADMIN;
        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     * @return \common\models\query\UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\UserQuery(get_called_class(), ['userType' => UserType::ROLE_ADMIN,  'tableName' => self::tableName()]);
    }
}
