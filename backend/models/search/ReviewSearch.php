<?php

namespace backend\models\search;

use Yii;
use backend\models\Review;
use yii\data\ActiveDataProvider;

class ReviewSearch
{
    public function search($p = null)
    {   
        $query = Review::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }
}