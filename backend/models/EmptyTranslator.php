<?php
namespace backend\models;

use Yii;
use yii\base\Model;

class emptyTranslator extends Model
{
    public function translate($string)
    {
        return $string;
    }
}