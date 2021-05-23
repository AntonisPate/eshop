<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use backend\models\Discount;
use backend\models\TranslationFactory;

class DiscountForm extends Model
{
    public $id;
    public $product_category_id;
    public $discount_percentance;
    public $message;
    public $from;
    public $to;
    public $title;

    private $discount;

    public function __construct($discount = null, $conf = [])
    {
        if ($discount != null) {
            $this->setDiscount($discount);
        }
    }
    public function rules()
    {
        return [
            [['product_category_id', 'discount_percentance'], 'required'],
            [['discount_percentance'], 'number'],
            [['message', 'title'], 'string'],
            [['from', 'to'], 'safe']
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
            'from' => $translator->translate('From'),
            'to' => $translator->translate('To'),
            'product_category_id' => $translator->translate('Product Category'),
            'discount_percentance' => $translator->translate('Discount Percentance'),
            'message' => $translator->translate('Message'),
            'title' => $translator->translate('Title'),
        ];
    }

    /**
     * Gets the value of discount.
     *
     * @return mixed
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    private function setDiscount($discount)
    {
        $this->discount = $discount;
        $this->product_category_id = $discount->product_category_id;
        $this->discount_percentance = $discount->getDiscountPercentance();
        $this->message = $discount->message;
        $this->from = $discount->getFormattedFromDate();
        $this->to = $discount->getFormattedToDate();
        $this->title = $discount->title;
    }

    public function save($discount = null)
    {
        if ($discount != null) {
            $discount->product_category_id = $this->product_category_id;
            $discount->discount_percentance = $this->discount_percentance;
            $discount->message = $this->message;
            $discount->to = $this->to;
            $discount->from = $this->from;
            $discount->title = $this->title;
            return $discount->save();
        } else {
            $discount = new Discount();
            $discount->product_category_id = $this->product_category_id;
            $discount->discount_percentance = $this->discount_percentance;
            $discount->message = $this->message;
            $discount->to = $this->to;
            $discount->from = $this->from;
            $discount->title = $this->title;
            return $discount->save();
        }
    }
}