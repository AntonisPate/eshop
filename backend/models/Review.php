<?php

namespace backend\models;
use Yii;
use backend\models\TranslationFactory;

class Review extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'review';
    }

    public function rules()
    {
        return [
            [['id', 'user_id', 'stars'], 'integer'],
            [['content'], 'string'],
            [['date'], 'safe'],
        ];
    }

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);    
    }
}