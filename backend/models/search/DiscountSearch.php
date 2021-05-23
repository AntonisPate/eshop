<?php

namespace backend\models\search;

use Yii;
use backend\models\Discount;
use backend\models\ProductCategory;
use yii\data\ActiveDataProvider;

class Discountsearch
{
    public function search($p = null, $category = null)
    {   
        if ($category == null) {
            $query = Discount::find();
        } else {
            $categoryObject = ProductCategory::findOne($category);

            if (!empty($categoryObject) && $categoryObject->sub_category_id == null) {
                $categories_to_search = $categoryObject->subCategoriesIds;
                $query = Discount::find()
                   ->where(['in', 'product_category_id', $categories_to_search]);
            } else {
                $query = Discount::find()
                        ->where(['in', 'product_category_id', $categoryObject->id]);
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }
}