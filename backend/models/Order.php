<?php

namespace backend\models;
use Yii;
use backend\models\TranslationFactory;
use common\models\User;

class Order extends \yii\db\ActiveRecord
{
    const FROM_STORE = 1;
    const SEND_TO_USER = 2;

    const PAY_WITH_CARD = 10;
    const PAY_WITH_BANK = 20;
    const PAY_ON_DELIVERY = 30;
    
    const STATUS_RECEIVED = 100;
    const STATUS_SENT = 200;
    const STATUS_DELIVERED = 300;
    const STATUS_CANCELLED = 400;
    const STATUS_COMPLETED = 500;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'transmit_type', 'pay_by', 'status'], 'number'],
            [['name', 'surname', 'address', 'city', 'postal_code', 'email', 'phone_number'], 'string'],
            [['date', 'data'], 'safe']
        ];
    }

    public function getFormattedDate()
    {
        return Yii::$app->formatter->asDate($this->date, 'dd-MM-yyyy');
    }

    public function setCompleted()
    {
        $this->status = self::STATUS_COMPLETED;
        if ($this->save()) {
            return true;
        }
        return false; 
    }

    public function setCancelled()
    {
        $this->status = self::STATUS_CANCELLED;
        if ($this->save()) {
            return true;
        }
        return false; 
    }

    public function setDelivered()
    {
        $this->status = self::STATUS_DELIVERED;
        if ($this->save()) {
            return true;
        }
        return false; 
    }

    public function setSend()
    {
        $this->status = self::STATUS_SENT;
        if ($this->save()) {
            return true;
        }
        return false;
    }

    public function getTotalPrice()
    {
        $out = 0;
        $order_data = json_decode($this->data);
        foreach($order_data->products as $key => $product_id) {
            $product = Product::findOne($product_id);
            $out += $product->totalPrice * $order_data->quantities[$key];
        }
        return $out;
    }

    public function getProducts()
    {
        $order_data = json_decode($this->data);
        $out = new \stdClass();
        $out = [];
        foreach($order_data->products as $key => $product_id) {
            $product = Product::findOne($product_id);
            $out [] = $product;
        }
        return $out;
    }

    public function getQuantityByProduct($product)
    {
        $order_data = json_decode($this->data);
        $out = new \stdClass();
        $out = [];
        foreach($order_data->products as $key => $product_id) {
            if ($product->id == $product_id) {
                return $order_data->quantities[$key];
            }
        }
    }

    public function getUserFullname()
    {
        if ($this->user_id != null) {
            $user = User::findOne($this->user_id);
            return $this->name . " " . $this->surname . " (". $user->name . " " . $user->surname . ")";
        }
        return   $this->name . " " . $this->surname . " (Guest)";
    }

    public function getTransmiType()
    {
        $type = $this->availableTransmitionTypes;
        return $type[$this->transmit_type];
    }

    public function getPaymentType()
    {
        $type = $this->availablePaymentTypes;
        return $type[$this->pay_by];
    }

    public function getStatusType()
    {
        $type = $this->availableStatuses;
        return $type[$this->status];
    }

    public static function getAvailablePaymentTypes()
    {
        $translatorFactory = new TranslationFactory();
        $translator = $translatorFactory->translator;

        return [
            self::PAY_WITH_CARD => $translator->translate('Pay with card'),
            self::PAY_WITH_BANK => $translator->translate('Immediate bank transfer'),
            self::PAY_ON_DELIVERY => $translator->translate('Pay on delivery'),
        ];
    }

    public static function getAvailableTransmitionTypes()
    {
        $translatorFactory = new TranslationFactory();
        $translator = $translatorFactory->translator;

        return [
            self::FROM_STORE => $translator->translate('Received from store'),
            self::SEND_TO_USER => $translator->translate('Shippment'),
        ];
    }

    public static function getStatusNameById($id)
    {
        $translatorFactory = new TranslationFactory();
        $translator = $translatorFactory->translator;
        
        switch ($id) {
            case self::STATUS_RECEIVED:
                return $translator->translate('Received');
                break;
            case self::STATUS_SENT:
                return $translator->translate('Sent');
                break;
            case self::STATUS_DELIVERED:
                return $translator->translate('Delivered');
                break;
            case self::STATUS_CANCELLED:
                return $translator->translate('Cancelled');
                break;
            case self::STATUS_COMPLETED:
                return $translator->translate('Completed');
                break;
            default:
                # code...
                break;
        }
    }

    public static function getAvailableStatuses()
    {
        $translatorFactory = new TranslationFactory();
        $translator = $translatorFactory->translator;

        return [
            self::STATUS_RECEIVED => $translator->translate('Received'),
            self::STATUS_SENT => $translator->translate('Sent'),
            self::STATUS_DELIVERED => $translator->translate('Delivered'),
            self::STATUS_CANCELLED => $translator->translate('Cancelled'),
            self::STATUS_COMPLETED => $translator->translate('Completed'),
        ];
    }
}