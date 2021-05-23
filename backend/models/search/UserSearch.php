<?php

namespace backend\models\search;

use Yii;
use common\models\User;
use yii\data\ActiveDataProvider;

class UserSearch
{
    public function search($p = null)
    {   
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }
}