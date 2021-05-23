<?php

namespace backend\helpers;
use Yii;
use yii\base\BaseObject;
use backend\models\TranslationFactory;
use backend\models\search\OrderSearch;
use backend\models\Order;
use common\models\User;

class ChartHelper extends BaseObject
{
    public static function getPerStatus($status)
    {
        $orders = Order::find()
                    ->where(['status' => $status])
                    ->all();
        return sizeof($orders); 
    }

    public static function getUserLabels()
    {
        $users = User::find()->all();
        $data = [];
        $data [0]= 'guest';
        foreach($users as $key => $user) {
            $data [] = $user->username;
        }
        return json_encode($data);
    }

    public static function getUserData()
    {
        $users = User::find()->all();
        $orders = Order::find()->all();
        $data = [];
        $data [0] = 0;
        foreach($users as $key => $user) {
            $data [$user->id] = 0;
        }
 
        foreach($orders as $key => $order) {    
            $data[$order->user_id != null ? $order->user_id : 0] += 1;
        }
        $out = [];
        foreach($data as $key => $count) {    
            $out [] = $count;
        }

        return json_encode($out);
    }

    public static function getUserColors()
    {
        $out = [];
        $users = User::find()->all();
        $out [0] = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
        foreach($users as $key => $user) {    
            $out [] = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
        }
        return json_encode($out);
    }

    public static function getUserBorderColors()
    {
        $out = [];
        $users = User::find()->all();
        $out [0] = '#686868';
        foreach($users as $key => $user) {    
            $out [] = '#686868';
        }
        return json_encode($out);
    }
}