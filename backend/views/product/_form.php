<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use trntv\filekit\widget\Upload;
use backend\models\Product;
use yii\web\JsExpression;
use yii\helpers\Url;
use backend\models\TranslationFactory;

$translatorFactory = new TranslationFactory();
$translator = $translatorFactory->translator;

/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="card">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label($translator->translate('Title')) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'english_title')->textInput(['maxlength' => true])->label($translator->translate('English Title')) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= 
                $form->field($model, 'category_id')->widget(Select2::classname(), [
                    'data' => $product_categories,
                    'options' => ['prompt' => $translator->translate('Select a Category ...') ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label($translator->translate('Category'));
            ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'price')->textInput()->label( $translator->translate('Price') ) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'description')->textarea(['rows' => 2])->label( $translator->translate('Description') ) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'english_description')->textarea(['rows' => 2])->label( $translator->translate('English Description') ) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'long_description')->textarea(['rows' => 6])->label( $translator->translate('Long Description') ) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'english_long_description')->textarea(['rows' => 6])->label( $translator->translate('English Long Description') ) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'image')->fileInput()->label($translator->translate('Image') ) ?>
            <?php if ($model->product != null) { ?>
                <?= Html::img('@web/uploads/' . $model->product->imageFile, ['style' => 'max-height: 200px;']) ?>
            <?php } ?>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?= Html::submitButton($translator->translate('Save'), ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>