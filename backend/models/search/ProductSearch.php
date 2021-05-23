<?php

namespace backend\models\search;

use Yii;
use backend\models\Product;
use backend\models\ProductCategory;
use yii\data\ActiveDataProvider;

class ProductSearch
{
    public function search($p = null, $category = null)
    {   
        if ($category == null) {
            $query = Product::find();
        } else {
            $categoryObject = ProductCategory::findOne($category);

            if (!empty($categoryObject) && $categoryObject->sub_category_id == null) {
                $categories_to_search = $categoryObject->subCategoriesIds;
                $query = Product::find()
                   ->where(['in', 'category_id', $categories_to_search]);
            } else {
                $query = Product::find()
                        ->where(['in', 'category_id', $categoryObject->id]);
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }
}