<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use backend\models\ProductCategory;
use backend\models\search\DiscountSearch;
use backend\models\Discount;

use backend\models\DiscountForm;

use backend\models\TranslationFactory;

class DiscountsController extends Controller
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
                        'actions' => ['index', 'create', 'update', 'delete'],
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

    public function actionIndex($category = null)
    {
        $session = Yii::$app->session;
        if (isset($session['language'])) {
            \Yii::$app->language = $session['language'];
        } else {
            \Yii::$app->language = 'el';
        }
        $categories = ProductCategory::getAvailable();

        if ($category == null) {
            $categoryObject = ProductCategory::find()->where(['shortname' => $categories[0]])->one();
        } else {
            $categoryObject = ProductCategory::find()->where(['shortname' => $category])->one();
        }

        $discountSearchModel = new DiscountSearch();
        $discountDataProvider = $discountSearchModel->search(Yii::$app->request->queryParams, $categoryObject->id);

        return $this->render('index',[
            'dataProvider' => $discountDataProvider,
            'searchModel' => $discountSearchModel,
            'category' => $categoryObject->shortname,
        ]);
    }

    public function actionUpdate($id = null)
    {
        $session = Yii::$app->session;
        if (isset($session['language'])) {
            \Yii::$app->language = $session['language'];
        } else {
            \Yii::$app->language = 'el';
        }
        $translatorFactory = new TranslationFactory();
        $translator = $translatorFactory->translator;

        if ($id == null) {
            return $this->redirect(['index', [
                'category' => ProductCategory::find()->one()->shortname,
            ]]);
        }

        $discount = Discount::findOne($id);
        $model = new DiscountForm($discount);

        if ($model->load(Yii::$app->request->post()) && $model->save($discount)) {
            Yii::$app->getSession()->addFlash('success', $translator->translate('The Discount was updated successfully'));
            return $this->redirect(['index', [
                'category' => ProductCategory::find()->one()->shortname,
            ]]);
        }

        $product_categories = ProductCategory::getDropDownOptions();

        return $this->render('update', [
            'model' => $model,
            'product_categories' => $product_categories,
        ]);
    }

    public function actionCreate()
    {
        $session = Yii::$app->session;
        if (isset($session['language'])) {
            \Yii::$app->language = $session['language'];
        } else {
            \Yii::$app->language = 'el';
        }
        $translatorFactory = new TranslationFactory();
        $translator = $translatorFactory->translator;
        
        $model = new DiscountForm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->addFlash('success', $translator->translate('The Discount was added successfully'));
            return $this->redirect(['index']);
        }
        $product_categories = ProductCategory::getDropDownOptions();
        return $this->render('create', [
            'model' => $model,
            'product_categories' => $product_categories
        ]);
    }

    public function actionDelete($id = null)
    {
        $session = Yii::$app->session;
        if (isset($session['language'])) {
            \Yii::$app->language = $session['language'];
        } else {
            \Yii::$app->language = 'el';
        }
        $translatorFactory = new TranslationFactory();
        $translator = $translatorFactory->translator;

        if($id == null) {
            return $this->redirect(['index', [
                'category' => ProductCategory::find()->one()->shortname,
            ]]);
        }

        $discount = Discount::findOne($id);
        if ($discount->delete()) {
            Yii::$app->getSession()->addFlash('success', $translator->translate('The Discount was deleted successfully'));
            return $this->redirect(['index', [
                'category' => ProductCategory::find()->one()->shortname,
            ]]);
        }
    }
}