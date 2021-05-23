<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use common\models\User;
use common\models\UserType;
use backend\models\UserForm;
use backend\models\search\UserSearch;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

use backend\models\TranslationFactory;

class UsersController extends Controller
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
                        'actions' => ['index', 'delete', 'update', 'create'],
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
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index',[
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionDelete($id)
    {
        $user = User::findOne($id);
    
        if ($user->delete()) {
            $translatorFactory = new TranslationFactory();
            $translator = $translatorFactory->translator;
            Yii::$app->getSession()->addFlash('success', $translator->translate('The User was deleted successfully'));
            return $this->goBack();
        }
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

        $user = User::findOne($id);
        $model = new UserForm($user);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->addFlash('success', $translator->translate('The user was updated successfully'));
            return $this->redirect(['index']);
        }
        $user_roles = UserType::getTypes();
        return $this->render('update', [
            'model' => $model,
            'user_roles' => $user_roles
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

        $user = new User();
        $model = new UserForm($user);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->addFlash('success', $translator->translate('The user was created successfully'));
            return $this->redirect(['index']);
        }
        $user_roles = UserType::getTypes();
        return $this->render('create', [
            'model' => $model,
            'user_roles' => $user_roles
        ]);
    }
}