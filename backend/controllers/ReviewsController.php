<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use backend\models\Review;
use backend\models\search\ReviewSearch;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

use backend\models\TranslationFactory;

class ReviewsController extends Controller
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
                        'actions' => ['index', 'delete'],
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

    public function actionIndex()
    {
        $searchModel = new ReviewSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index',[
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionDelete($id)
    {
        $review = Review::findOne($id);
        $produst = $review->product;
        if ($review->delete()) {
            $produst->calculateRating();
            $translatorFactory = new TranslationFactory();
            $translator = $translatorFactory->translator;
            Yii::$app->getSession()->addFlash('success', $translator->translate('The Review was deleted successfully'));
            return $this->goBack();
        }
    }
}