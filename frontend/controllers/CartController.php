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
use backend\models\ProductCategory;
use common\models\User;

/**
 * Cart controller
 */
class CartController extends Controller
{
    public function actionGetData($user_id)
    {
        $session = Yii::$app->session;

        $out ['results'] = [];
        if ($user_id != 0) {
            if (isset($session['cart_'.$user_id])) {
                $products = $session['cart_'.$user_id]['product'];
                $quantities = $session['cart_'.$user_id]['quantity'];
                foreach($products as $key => $product) {
                    $product = Product::findOne($product);
                    $out ['results'] ['products'] [] = $product->attributes;
                    $out ['results'] ['quantity'] [] = $quantities[$key];
                }
                return json_encode($out);
            } else {
                var_dump('a').die();
            }
        } else {
            if (isset($session['cart_quest'])) {
                $products = $session['cart_quest']['product'];
                $quantities = $session['cart_quest']['quantity'];
                foreach($products as $key => $product) {
                    $product = Product::findOne($product);
                    $out ['results'] ['products'] [] = $product->attributes;
                    $out ['results'] ['quantity'] [] = $quantities[$key];
                }
                return json_encode($out);
            }  
        }
        return false;
    }

    public function actionUpdate() {
        $post = Yii::$app->request->post();
        $session = Yii::$app->session;
        $user_id = Yii::$app->user->id != null ? Yii::$app->user->id : 'quest';
        if (isset($session['cart_' . $user_id])) {
            $quantities = $session['cart_' . $user_id]['quantity'];
            $products = $session['cart_' . $user_id]['product'];
            $index = array_search($post['product_id'], $products);
            $quantities[$index] = $post['quantity'];
            $session['cart_' . $user_id] = [
                'product' => $products,
                'quantity' => $quantities
            ];
        }
    }

    public function actionGetTotalAmount() {
        $session = Yii::$app->session;
        $user_id = Yii::$app->user->id != null ? Yii::$app->user->id : 'quest';
        $amount = 0;
        if (isset($session['cart_' . $user_id])) {
            $products = $session['cart_' . $user_id]['product'];
            $quantities = $session['cart_' . $user_id]['quantity'];
            foreach($products as $key => $product_id) {
                $product = Product::findOne($product_id);
                $amount += $product->totalPrice * $quantities[$key];
            }
        }
        return $amount;
    }

    public function actionGetProductQuantity($product_id) {
        if ($product_id != null) {
            $session = Yii::$app->session;
            $user_id = Yii::$app->user->id != null ? Yii::$app->user->id : 'quest';
            if (isset($session['cart_' . $user_id])) {
                $quantities = $session['cart_' . $user_id]['quantity'];
                $products = $session['cart_' . $user_id]['product'];
                $index = array_search($product_id, $products);
                return $quantities[$index];
            }
        }
        return 0;
    }

    public function actionRemoveProduct($product_id) {
        if ($product_id != null) {
            $session = Yii::$app->session;
            $user_id = Yii::$app->user->id != null ? Yii::$app->user->id : 'quest';
            if (isset($session['cart_' . $user_id])) {
                $quantities = $session['cart_' . $user_id]['quantity'];
                $products = $session['cart_' . $user_id]['product'];
                $index = array_search($product_id, $products);
                unset($products[$index]);
                unset($quantities[$index]);
                $session['cart_' . $user_id] = [
                    'product' => $products,
                    'quantity' => $quantities
                ];
                return true;
            }
        }
        return false; 
    }
}