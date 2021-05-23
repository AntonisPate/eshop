<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use backend\models\TranslationFactory;
use backend\models\Order;

class OrderForm extends Model
{
    public $user_id;
    public $products = [];
    public $quantities = [];
    public $name;
    public $surname;
    public $address;
    public $city;
    public $postal_code;
    public $email;
    public $transmit_type;
    public $pay_by;
    public $phone_number;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'products', 'quantities', 'name', 'surname' , 'email', 
                'transmit_type', 'pay_by', 'phone_number'], 'required'],
            [['address', 'city', 'postal_code'], 'string']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        $translatorFactory = new TranslationFactory();
        $translator = $translatorFactory->translator;

        return [
            'name' => $translator->translate('Name'),
            'surname' => $translator->translate('Surname'),
            'address' => $translator->translate('Address'),
            'city' => $translator->translate('City'),
            'postal_code' => $translator->translate('Postal Code'),
            'email' => $translator->translate('Email'),
            'phone_number' => $translator->translate('Phone Number'),
        ];
    }

    public function save()
    {
        $order = new Order();

        $order->user_id = Yii::$app->user != null ? Yii::$app->user->id : 0;
        $order->transmit_type = $this->transmit_type;
        $order->pay_by = $this->pay_by;
        $order->status = Order::STATUS_RECEIVED;
        $order->name = $this->name;
        $order->surname = $this->surname;
        $order->address = $this->address;
        $order->city = $this->city;
        $order->postal_code = $this->postal_code;
        $order->email = $this->email;
        $order->date = date("Y-m-d");
        $order->phone_number = $this->phone_number;

        $id = Yii::$app->user->id != null ? Yii::$app->user->id : 'quest';
        $session = Yii::$app->session;
        
        if (isset($session['cart_'.$id])) {
            $products = $session['cart_'.$id]['product'];
            $quantities = $session['cart_'.$id]['quantity'];
            $object = new \stdClass();
            $object->products = $products;
            $object->quantities = $quantities;
            $order->data = json_encode($object);

            if ($order->save()) {
                unset($session['cart_'.$id]);
                return true;
            }
        }

        return false;
    }
}
