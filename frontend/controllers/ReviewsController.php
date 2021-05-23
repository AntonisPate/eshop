<?php
namespace frontend\controllers;


use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;
use backend\models\Review;
use backend\models\Product;
use common\models\User;

class ReviewsController extends Controller
{
    public function actionAdd()
    {
        $post = Yii::$app->request->post();
        $review = new Review();
        $review->user_id = Yii::$app->user->id != null ? Yii::$app->user->id : 0;
        $review->date = date("Y-m-d");
        $review->stars = $post['stars'];
        $review->content = $post['content'];
        $review->product_id = $post['product_id'];
        $product = Product::findOne($post['product_id']);

        $user = User::findOne($review->user_id);
        $review->user_fullname = $user != null ? $user->name . " " . $user->surname : 'Guest';

        if ($review->save()) {
            $product->calculateRating();
            return true;
        }
    }

    public function actionGetData($product_id)
    {
        $reviews = Review::find()->where(['product_id' => $product_id])->all();
             
        $reviewsData = [];
        foreach($reviews as $key => $review) {
            $reviewsData[] = $review->attributes;
        }

        return json_encode($reviewsData);
    }
}