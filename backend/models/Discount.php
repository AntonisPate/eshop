<?php

namespace backend\models;
use backend\models\ProductCategory;
use Yii;
use backend\models\TranslationFactory;

class Discount extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'discount';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'product_category_id', 'product_sub_category_id', 'discount_percentance'], 'number'],
            [['message'], 'string'],
            [['from', 'to'], 'safe']
        ];
    }

    public function getProductCategory()
    {
        return $this->hasOne(ProductCategory::className(), ['id' => 'product_category_id']);    
    }

    public function getProductCategoryName()
    {
        $translatorFactory = new TranslationFactory();
        $translator = $translatorFactory->translator;

        $category = $this->getProductCategory()->one();
        if (!empty($category)) {
            return $translator->translate($category->primary_name);
        }
        return '';
    }

    public function getDiscount()
    {
        return $this->discount_percentance / 1000;
    }

    public function getDiscountPercentance()
    {
        return $this->discount_percentance / 1000;
    }

    public function getFormattedFromDate()
    {
        if ($this->from !== null ){
            return Yii::$app->formatter->asDate($this->from, Yii::$app->formatter->dateFormat);
        }
    }

    public function getFormattedToDate()
    {
        if ($this->to !== null ){
            return Yii::$app->formatter->asDate($this->to, Yii::$app->formatter->dateFormat);
        }
    }
    
    /**
     * {@inheritdoc}
     * @return DiscountQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DiscountQuery(get_called_class());
    }

}