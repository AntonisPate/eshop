<?php

namespace backend\models\search;

use Yii;
use backend\models\Order;
use yii\data\ActiveDataProvider;

class OrderSearch
{
    public function search($p = null)
    {   
        $query = Order::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }
}