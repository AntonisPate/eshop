<?php
namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use backend\models\Product;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public function actionIndex()
    {
        $session = Yii::$app->session;
        if (isset($session['language'])) {
            \Yii::$app->language = $session['language'];
        } else {
            \Yii::$app->language = 'el';
        }

        $productsData = [];


        $products = Product::find()
            ->orderBy(['clicks' => SORT_DESC])
            ->limit(5)
            ->all();

        foreach($products as $product) {
            $productsData [] = $product->attributes;
        }

        return $this->render('/product/popular', [
            'products' => json_encode($productsData)
        ]);
    }

    public function actionChangeLanguage($language = null)
    {
        if ($language != null) {
            $session = Yii::$app->session;
            $session['language'] = $language;
        } else {
            $session = Yii::$app->session;
            $session['language'] = 'el';
        }
        
        return $this->render('index');
    }
}