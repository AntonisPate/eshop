<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use backend\models\UploadForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use backend\models\search\OrderSearch;
use backend\models\TranslationFactory;
use backend\models\Order;
use backend\models\OrderPdf;
use backend\helpers\ChartHelper;

class OrdersController extends Controller
{
  /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['pdf', 'index', 'delete', 'view', 'set-send', 'set-delivered', 'set-cancelled', 'set-completed'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex($tab = null)
    {
        $session = Yii::$app->session;
        if (isset($session['language'])) {
            \Yii::$app->language = $session['language'];
        } else {
            \Yii::$app->language = 'el';
        }
        
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $ordersChartData = [];
        $tab = $tab != null ? $tab : 'gridview';

        if ($tab == 'gridview') {
            return $this->render('index',[
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'ordersChartData' => json_encode($ordersChartData),
                'tab' => $tab,
                'receivedData' => 0,
                'sentdData' => 0,
                'deliveredData' => 0,
                'cancelledData' => 0,
                'completedData' => 0,
            ]);
        } else {
            $receivedData = ChartHelper::getPerStatus(Order::STATUS_RECEIVED);
            $sentdData = ChartHelper::getPerStatus(Order::STATUS_SENT);
            $deliveredData = ChartHelper::getPerStatus(Order::STATUS_DELIVERED);
            $cancelledData = ChartHelper::getPerStatus(Order::STATUS_CANCELLED);
            $completedData = ChartHelper::getPerStatus(Order::STATUS_COMPLETED);
            return $this->render('index',[
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'ordersChartData' => json_encode($ordersChartData),
                'tab' => $tab,
                'receivedData' => $receivedData,
                'sentdData' => $sentdData,
                'deliveredData' => $deliveredData,
                'cancelledData' => $cancelledData,
                'completedData' => $completedData,
            ]);
        }
  
    }

    public function actionPdf($id)
    {
        $model = Order::findOne($id);
        $pdfGenerator = new OrderPdf($model);
        return $pdfGenerator->generate();
    }

    public function actionSetCompleted($id)
    {
        $translatorFactory = new TranslationFactory();
        $translator = $translatorFactory->translator;
        
        $session = Yii::$app->session;
        if (isset($session['language'])) {
            \Yii::$app->language = $session['language'];
        } else {
            \Yii::$app->language = 'el';
        }

        $order = Order::findOne($id);

        if ($order->setCompleted()) {
            Yii::$app->getSession()->addFlash('success', $translator->translate('The order was completed successfully'));
            return $this->redirect(['index', [
            ]]);
        }
    }

    public function actionSetCancelled($id)
    {
        $translatorFactory = new TranslationFactory();
        $translator = $translatorFactory->translator;
        
        $session = Yii::$app->session;
        if (isset($session['language'])) {
            \Yii::$app->language = $session['language'];
        } else {
            \Yii::$app->language = 'el';
        }

        $order = Order::findOne($id);

        if ($order->setCancelled()) {
            Yii::$app->getSession()->addFlash('success', $translator->translate('The order was cancelled successfully'));
            return $this->redirect(['index', [
            ]]);
        }
    }

    public function actionSetDelivered($id)
    {
        $translatorFactory = new TranslationFactory();
        $translator = $translatorFactory->translator;
        
        $session = Yii::$app->session;
        if (isset($session['language'])) {
            \Yii::$app->language = $session['language'];
        } else {
            \Yii::$app->language = 'el';
        }

        $order = Order::findOne($id);

        if ($order->setDelivered()) {
            Yii::$app->getSession()->addFlash('success', $translator->translate('The order was delivered successfully'));
            return $this->redirect(['index', [
            ]]);
        }
    }

    public function actionSetSend($id)
    {
        $translatorFactory = new TranslationFactory();
        $translator = $translatorFactory->translator;

        $session = Yii::$app->session;
        if (isset($session['language'])) {
            \Yii::$app->language = $session['language'];
        } else {
            \Yii::$app->language = 'el';
        }

        $order = Order::findOne($id);

        if ($order->setSend()) {
            Yii::$app->getSession()->addFlash('success', $translator->translate('The order was sent successfully'));
            return $this->redirect(['index', [
            ]]);
        }
    }

    public function actionView($id)
    {
        $session = Yii::$app->session;
        if (isset($session['language'])) {
            \Yii::$app->language = $session['language'];
        } else {
            \Yii::$app->language = 'el';
        }

        $order = Order::findOne($id);
        return $this->render('view',[
            'model' => $order,
        ]);
    }

    public function actionDelete($id)
    {
        $translatorFactory = new TranslationFactory();
        $translator = $translatorFactory->translator;

        $order = Order::findOne($id);
        if ($order->delete()) {
            Yii::$app->getSession()->addFlash('success', $translator->translate('The order was deleted successfully'));
            return $this->redirect(['index', [
            ]]);
        }
    }
}