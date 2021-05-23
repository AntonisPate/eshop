<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use backend\models\Product;

class ProductForm extends Model
{
    public $id;
    public $title;
    public $price;
    public $description;
    public $category_id;
    public $discount_id;
    public $rating;
    public $image;

    public $imageFile;

    public $long_description;

    public $english_long_description;
    public $english_description;
    public $english_title;

    private $product;

    public function __construct($product = null, $conf = [])
    {
        if ($product != null) {
            $this->setProduct($product);
        }
    }

    public function rules()
    {
        return [
            [['title', 'price', 'description'], 'required'],
            [['title', 'price', 'description', 'long_description', 'english_long_description',
            'english_description', 'english_title'], 'string'],
            [['price', 'category_id', 'discount_id', 'rating'], 'number'],
            ['id', 'integer']
        ];
    }

    /**
     * Gets the value of product.
     *
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    private function setProduct($product)
    {
        $this->product = $product;
        $this->id = $product->id;
        $this->title = $product->title;
        $this->price = $product->getPrice();
        $this->description = $product->description;
        $this->category_id = $product->category_id;
        $this->discount_id = $product->discount_id;
        $this->image = $product->image;
        $this->long_description = $product->long_description;
        $this->english_long_description = $product->english_long_description;
        $this->english_description = $product->english_description;
        $this->english_title = $product->english_title;
    }

    public function save($product = null)
    {
        if ($product != null) {
            var_dump($product->errors).die();

            $product->title = $this->title;
            $product->price = $this->price;
            $product->description = $this->description;
            $product->category_id = $this->category_id;
            $product->discount_id = $this->discount_id;
            $product->image = $this->image;
            $product->long_description = $this->long_description;
            $product->english_long_description = $this->english_long_description;
            $product->english_description = $this->english_description;
            $product->english_title = $this->english_title;

            return $product->save();
        } else {
            $product = new Product();
            $product->title = $this->title;
            $product->price = $this->price;
            $product->description = $this->description;
            $product->category_id = $this->category_id;
            $product->discount_id = $this->discount_id;
            $product->image = $this->image;
            $product->long_description = $this->long_description;
            $product->english_long_description = $this->english_long_description;
            $product->english_description = $this->english_description;
            $product->english_title = $this->english_title;
            if ($product->save()) {
                $this->id = $product->id;
                return true;
            }
        }
    }
}