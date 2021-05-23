<?php

namespace backend\models;
use backend\models\ProductCategory;
use Yii;
use backend\models\TranslationFactory;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string|null $title
 * @property float|null $price
 * @property string|null $description
 * @property int|null $category_id
 * @property int|null $discount_id
 * @property float|null $rating
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['id', 'integer'],
            [['price', 'rating'], 'number'],
            [['description'], 'string'],
            [['category_id', 'discount_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'price' => Yii::t('app', 'Price'),
            'description' => Yii::t('app', 'Description'),
            'category_id' => Yii::t('app', 'Category ID'),
            'discount_id' => Yii::t('app', 'Discount ID'),
            'rating' => Yii::t('app', 'Rating'),
        ];
    }

    public function getProductCategory()
    {
        return $this->hasOne(ProductCategory::className(), ['id' => 'category_id']);    
    }

    public function getReviews()
    {
        return $this->hasOne(Review::className(), ['product_id' => 'id']);    
    }

    public function getPdfTitle()
    {
        $session = Yii::$app->session;
        if (isset($session['language'])) {
            if ($session['language'] == 'el') {
                return $this->title;
            }
        }
        return $this->english_title;
    }

    public function calculateRating()
    {
        $reviews = $this->getReviews()->all();
        $total = 0;
        foreach($reviews as $review) {
            $total += $review->stars;
        }
        if (count($reviews)) {
            $this->rating = (int)($total / count($reviews));
        } else {
            $this->rating = 0;
        }
        $this->save();
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
    
    public function getPrice()
    {
        return $this->price;
    }

    public function getDiscounts()
    {
        return $this->hasMany(Discount::className(), ['product_category_id' => 'category_id']);
    }

    public function getDiscountTitle()
    {
        $discount = Discount::findOne($this->discount_id);

        if (!empty($discount)) {
            return $discount->title;
        }
    }

    public function getTotalPrice()
    {
        $discounts = $this->discounts;
        $max_discount = 0;
        foreach($discounts as $discount) {
            $max_discount = $max_discount < $discount->discount_percentance ? $discount->discount_percentance : $max_discount;
        }
        $out = $this->price - ($this->price * ($max_discount / 100));
        return $out;
    }

    public function getTotalPricePdf()
    {
        $discounts = $this->discounts;
        $max_discount = 0;
        foreach($discounts as $discount) {
            $max_discount = $max_discount < $discount->discount_percentance ? $discount->discount_percentance : $max_discount;
        }
        $out = $this->price - ($this->price * ($max_discount / 100));
        return number_format((float)$out, 2, '.', '');
    }

    public function getImageFile()
    {
        if ( file_exists(Yii::$app->basePath . '/web/uploads/' . $this->id.'.jpg') ) {
            return $this->id.'.jpg';
        } else if (file_exists(Yii::$app->basePath . '/web/uploads/' . $this->id.'.png')) {
            return $this->id.'.png';
        }
    }

    public function getImagePath()
    {
        return Url::to('@backend/web/uploads/119.jpg');
    }
    
    /**
     * {@inheritdoc}
     * @return ProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductQuery(get_called_class());
    }
}
