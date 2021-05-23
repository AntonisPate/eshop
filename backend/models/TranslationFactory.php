<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use backend\Models\TranslationEl;
use backend\Models\EmptyTranslator;

class TranslationFactory extends Model
{
    public $translator;

    public function __construct($conf = [])
    {
        if (Yii::$app->language == 'el') {
            $this->translator = new TranslationEl();
        } else {
            $this->translator = new EmptyTranslator();
        }
    }
}