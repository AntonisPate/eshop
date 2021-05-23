<?php
namespace frontend\controllers;


use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;
use backend\models\Product;
use backend\models\Discount;
use backend\models\ProductCategory;
use backend\models\Review;
use common\models\User;

/**
 * Product controller
 */
class ProductController extends Controller
{
    public function actionView($id)
    {
        $session = Yii::$app->session;
        if (isset($session['language'])) {
            \Yii::$app->language = $session['language'];
        } else {
            \Yii::$app->language = 'el';
        }
        $product = Product::findOne($id);
        if (!empty($product)) {
            $product->clicks ++;
            $product->save();

            $reviews = Review::find()->where(['product_id' => $id])->all();
             
            $reviewsData = [];
            foreach($reviews as $key => $review) {
                $reviewsData[] = $review->attributes;
            }

            return $this->render('view', [
                'model' => $product,
                'reviews' => json_encode($reviewsData)
            ]);
        }
    }

    public function actionAddToCart($id)
    {
        $post = Yii::$app->request->post();
        $session = Yii::$app->session;
        $user_id = Yii::$app->user->id != null ? Yii::$app->user->id : 'quest';
        if (isset($post['quantity'])) {
            if (isset( $session['cart_' . $user_id])) {
                $products = $session['cart_' . $user_id]['product'];
                $quantities = $session['cart_' . $user_id]['quantity'];
                $index = array_search($id, $products);
                
                if ($index || $index === 0) {
                    $quantities[$index] +=  $post['quantity'];
                    $session['cart_' . $user_id] = [
                        'product' => $products,
                        'quantity' => $quantities
                    ];
                } else {
                    $products []= $id;
                    $quantities = $session['cart_' . $user_id]['quantity'];
                    $quantities []=  $post['quantity'];
                    $session['cart_' . $user_id] = [
                        'product' => $products,
                        'quantity' => $quantities
                    ];
                }
            } else {
                $session['cart_' . $user_id] = [
                    'product' => [$id],
                    'quantity' => [$post['quantity']]
                ];
            }
            return true;
        }
        return true;
    }

    public function actionSearch($search) 
    {
        $session = Yii::$app->session;
        if (isset($session['language'])) {
            \Yii::$app->language = $session['language'];
        }

        if (Yii::$app->language == 'el') {
            $products = Product::find()
                    ->where(['like', Product::tableName().'.title', $search])
                    ->all();
        } else {
            $products = Product::find()
                    ->where(['like', Product::tableName().'.english_title', $search])
                    ->all();
        }
        
                    
        $productsData = [];
        foreach($products as $product) {
            $productsData [] = $product->attributes;
        }
        return $this->render('search', [
            'products' => json_encode($productsData)
        ]);
    }

    public function actionOffers()
    {
        $session = Yii::$app->session;
        if (isset($session['language'])) {
            \Yii::$app->language = $session['language'];
        } else {
            \Yii::$app->language = 'el';
        }
        $discounts = Discount::find()->all();
        $ids = [];
        $productsData = [];
        foreach($discounts as $key => $discount) {
            $ids [] = $discount->product_category_id;
        }
        foreach($ids as $id) {
            $products = Product::find()->where(['category_id' => $id])->all();
            foreach($products as $product) {
                $productsData [] = $product->attributes;
            }
        }
        return $this->render('offers', [
            'products' => json_encode($productsData)
        ]);
    }

    public function actionPopular()
    {
        $session = Yii::$app->session;
        if (isset($session['language'])) {
            \Yii::$app->language = $session['language'];
        } else {
            \Yii::$app->language = 'el';
        }
        $discounts = Discount::find()->all();
        $ids = [];
        $productsData = [];
        foreach($discounts as $key => $discount) {
            $ids [] = $discount->product_category_id;
        }
        foreach($ids as $id) {
            $products = Product::find()->where(['category_id' => $id])->all();
            foreach($products as $product) {
                $productsData [] = $product->attributes;
            }
        }

        return $this->render('popular', [
            'products' => json_encode($productsData)
        ]);
    }

    public function actionFertilizers() {
        $session = Yii::$app->session;
        if (isset($session['language'])) {
            \Yii::$app->language = $session['language'];
        } else {
            \Yii::$app->language = 'el';
        }

        $product_category =  ProductCategory::find()
                            ->where(['primary_name' => 'fertilizers'])
                            ->one();

        return $this->render('index', [
            'product_category' => $product_category,
            'url' => Url::to(['/product/get-data']) . '?primary_name=' . $product_category->primary_name,
            'imageUrl' => Url::to(['/product/get-image-path'])
        ]);
    }

    public function actionSeeds($subCategoryId = null) {
        $session = Yii::$app->session;
        if (isset($session['language'])) {
            \Yii::$app->language = $session['language'];
        } else {
            \Yii::$app->language = 'el';
        }

        if ($subCategoryId != null) {
            $product_category =  ProductCategory::find()
            ->where(['id' => $subCategoryId])
            ->one();
        } else {
            $product_category =  ProductCategory::find()
            ->where(['primary_name' => 'seeds'])
            ->one();
        }

        return $this->render('index', [
            'product_category' => $product_category,
            'url' => Url::to(['/product/get-data']) . '?primary_name=' . $product_category->primary_name,
            'imageUrl' => Url::to(['/product/get-image-path'])
        ]);
    }

    public function actionPlantsTrees($subCategoryId = null) {
        $session = Yii::$app->session;
        if (isset($session['language'])) {
            \Yii::$app->language = $session['language'];
        } else {
            \Yii::$app->language = 'el';
        }

        if ($subCategoryId != null) {
            $product_category =  ProductCategory::find()
            ->where(['id' => $subCategoryId])
            ->one();
        } else {
            $product_category =  ProductCategory::find()
                ->where(['primary_name' => 'plants trees'])
                ->one();
        }

        return $this->render('index', [
            'product_category' => $product_category,
            'url' => Url::to(['/product/get-data']) . '?primary_name=' . $product_category->primary_name,
            'imageUrl' => Url::to(['/product/get-image-path'])
        ]);
    }

    public function actionGardenEquipment($subCategoryId = null) {
        $session = Yii::$app->session;
        if (isset($session['language'])) {
            \Yii::$app->language = $session['language'];
        } else {
            \Yii::$app->language = 'el';
        }

        if ($subCategoryId != null) {
            $product_category =  ProductCategory::find()
            ->where(['id' => $subCategoryId])
            ->one();
        } else {
            $product_category =  ProductCategory::find()
                            ->where(['primary_name' => 'garden equipment'])
                            ->one();
        }

        return $this->render('index', [
            'product_category' => $product_category,
            'url' => Url::to(['/product/get-data']) . '?primary_name=' . $product_category->primary_name,
            'imageUrl' => Url::to(['/product/get-image-path'])
        ]);
    }

    public function actionProtectionEquipment($subCategoryId = null) {
        $session = Yii::$app->session;
        if (isset($session['language'])) {
            \Yii::$app->language = $session['language'];
        } else {
            \Yii::$app->language = 'el';
        }

        if ($subCategoryId != null) {
            $product_category =  ProductCategory::find()
            ->where(['id' => $subCategoryId])
            ->one();
        } else {
            $product_category =  ProductCategory::find()
                            ->where(['primary_name' => 'protection equipment'])
                            ->one();
        }

        return $this->render('index', [
            'product_category' => $product_category,
            'url' => Url::to(['/product/get-data']) . '?primary_name=' . $product_category->primary_name,
            'imageUrl' => Url::to(['/product/get-image-path'])
        ]);
    }

    public function actionGetData($primary_name = null) {
        $session = Yii::$app->session;
        if (isset($session['language'])) {
            \Yii::$app->language = $session['language'];
        } else {
            \Yii::$app->language = 'el';
        }
        
        if ($primary_name == null) {
            return $out ['results'] [] = 'No results';
        }
         
        $product_categories =  ProductCategory::find()
                            ->where(['primary_name' => $primary_name])
                            ->orWhere(['shortname' => $primary_name])
                            ->all();

        $ids = [];

        foreach($product_categories as $product_category) {
            $ids [] = $product_category->id;
        }

        $products = Product::find()
                    ->where(['IN', 'category_id', $ids])
                    ->all();
        
        if (!empty($products)) {
            foreach($products as $product) {
                $out ['results'] [] = $product->attributes;
            }
            return json_encode($out);
        }
        return $out ['results'] [] = 'No results';
    }

    public function actionGetTotalPrice($id = null)
    {
        if ($id != null) {
            $product = Product::findOne($id);
            return $product->totalPrice;
        }
    }
}
