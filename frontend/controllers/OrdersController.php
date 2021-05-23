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
use frontend\models\OrderForm;
use backend\models\Order;

/**
 * Orders controller
 */
class OrdersController extends Controller
{
    public function actionIndex()
    {
        $model = new OrderForm();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['success']);
        }
        $transmit_types = Order::getAvailableTransmitionTypes();
        $payment_types = Order::getAvailablePaymentTypes();
        return $this->render('_form',[
            'model' => $model,
            'transmit_types' => $transmit_types,
            'payment_types' => $payment_types
        ]);
    }

    public function actionSuccess()
    {
        return $this->render('success',[
            
        ]);
    }
}