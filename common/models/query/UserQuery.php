<?php

namespace common\models\query;

use common\models\User;
use common\models\BaseUser;

/**
 * This is the ActiveQuery class for [[\common\models\User]].
 *
 * @see \common\models\User
 */
class UserQuery extends \yii\db\ActiveQuery
{

    public $userType;
    public $tableName;

    /**
     * @inheritdoc
     */
    public function prepare($builder)
    {
        if ($this->userType !== null) {
           $this->andWhere(["$this->tableName.user_type" => $this->userType]);
        }
        return parent::prepare($builder);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\User[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\User|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\User|array|null
     */
    public function active($alias = null) {
        if ($alias == null) {
            $alias = BaseUser::tableName();
        }
        return $this->andWhere([$alias.'.status' => BaseUser::STATUS_ACTIVE]);
    }
}
