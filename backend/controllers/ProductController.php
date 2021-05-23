<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use backend\models\search\ProductSearch;
use backend\models\ProductForm;
use backend\models\Product;
use backend\models\Discount;
use backend\models\ProductCategory;
use backend\models\UploadForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

use backend\models\TranslationFactory;

class ProductController extends Controller
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

        $productSearchModel = new ProductSearch();
        $productDataProvider = $productSearchModel->search(Yii::$app->request->queryParams, $categoryObject->id);
        $dicounts = Discount::find()->all();

        return $this->render('index',[
            'dataProvider' => $productDataProvider,
            'searchModel' => $productSearchModel,
            'category' => $categoryObject->shortname,
            'dicounts' => $dicounts,
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

        $model = new ProductForm();
        $uploadModel = new UploadForm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $uploadModel->imageFile = UploadedFile::getInstance($model, 'image');
            $uploadModel->upload($model->id);
            Yii::$app->getSession()->addFlash('success', $translator->translate('The Product was added successfully'));
            return $this->redirect(['index']);
        }
        $product_categories = ProductCategory::getDropDownOptions();
        $dicounts = Discount::find()->all();
        
        return $this->render('create', [
            'model' => $model,
            'product_categories' => $product_categories,
            'discounts' => ArrayHelper::map($dicounts, 'id', 'title')
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

        $product = Product::findOne($id);
        $model = new ProductForm($product);
        $uploadModel = new UploadForm();
    
        if ($model->load(Yii::$app->request->post()) && $model->save($product)) {
            $uploadModel->imageFile = UploadedFile::getInstance($model, 'image');
            $uploadModel->upload($product->id);
            Yii::$app->getSession()->addFlash('success', $translator->translate('The Product was updated successfully'));
            return $this->redirect(['index', [
                'category' => ProductCategory::find()->one()->shortname,
            ]]);
        }

        $product_categories = ProductCategory::getDropDownOptions();

        $dicounts = Discount::find()->all();

        return $this->render('update', [
            'model' => $model,
            'product_categories' => $product_categories,
            'discounts' => ArrayHelper::map($dicounts, 'id', 'title')
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

        $product = Product::findOne($id);
        if ($product->delete()) {
            Yii::$app->getSession()->addFlash('success', $translator->translate('The Product was deleted successfully'));
            return $this->redirect(['index', [
                'category' => ProductCategory::find()->one()->shortname,
            ]]);
        }
    }

}
