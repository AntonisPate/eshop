<?php
namespace frontend\controllers;


use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\User;

/**
 * User controller
 */
class UserController extends Controller
{
    public function actionRegister()
    {
        $post = Yii::$app->request->post();
        $user = User::find()->where(['username' => $post['username']])->one();
        if (empty($user)) {
            $user = User::find()->where(['email' => $post['email']])->one();
            if (empty($user)) {
                $registerUser = new User();
                $registerUser->username = $post['username'];
                $registerUser->setPassword($post['password']);
                $registerUser->email = $post['email'];
                $registerUser->status = User::STATUS_ACTIVE;
                $registerUser->name =  $post['name'];
                $registerUser->surname =  $post['surname'];
                if ($registerUser->save()) {
                    return json_encode(['status' => true]);
                }
            } else {
                return json_encode(['status' => false, 'message' => 'Email already exists']);
            }
        } else {
            return json_encode(['status' => false, 'message' => 'Username already exists']);
        }
    }

    public function actionLogIn()
    {
        $post = Yii::$app->request->post();

        $user = User::find()->where(['username' => $post['username']])->one();

        if (empty($user)) {
            return json_encode(['status' => false, 'message' => 'The user does not exist']);
        } else {
            if ($user->validatePassword($post['password'])) {
                Yii::$app->user->login($user, 0);
                return $this->goBack();
            } else {
                return json_encode(['status' => false, 'message' => 'Wrong password']);
            }
        }
    }

    public function actionLogOut()
    {
        Yii::$app->user->logout(true);
        return $this->goBack();
    }

    public function actionUpdate($id)
    {
        $post = Yii::$app->request->post();

        $user = User::findOne($id);
        if (!empty($user)) {
            if (isset($post['password']) && $post['password'] != "") {
                $user->setPassword($post['password']);
            }
            if (isset($post['email']) && $post['email'] != "") {
                $user->email = $post['email'];
            }
            if (isset($post['name']) && $post['name'] != "") {
                $user->name =  $post['name'];
            }
            if (isset($post['surname']) && $post['surname'] != "") {
                $user->surname =  $post['surname'];
            }
            if ($user->save()) {
                return $this->goBack();
            }
        }
    }
}