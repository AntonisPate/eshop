<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;

use backend\models\TranslationFactory;

$translatorFactory = new TranslationFactory();
$translator = $translatorFactory->translator;

/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="card">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'title')->textInput() ?>
        </div>
        <div class="col-md-6">
            <?= 
                $form->field($model, 'product_category_id')->widget(Select2::classname(), [
                    'data' => $product_categories,
                    'options' => ['prompt' => $translator->translate('Select a Category ...')],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'discount_percentance')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'from')->widget(DatePicker::class, [
                'type' => DatePicker:: TYPE_COMPONENT_APPEND,
                'pickerIcon' => '<i class="fa fa-calendar kv-dp-icon"></i>',
                'removeIcon' => '<i class="fas fa-times kv-dp-icon"></i>',
                'convertFormat' => false,
                'options' => [
                    'class' => 'form-control underlined'
                ],
                'pluginOptions' => [
                    'format' => 'yyyy-mm-dd',
                    'autoclose'=> true,
                    'minViewMode' => 'days', // months
                    'startView' => 'days',// decade
                ],
            ]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'to')->widget(DatePicker::class, [
                'type' => DatePicker:: TYPE_COMPONENT_APPEND,
                'pickerIcon' => '<i class="fa fa-calendar kv-dp-icon"></i>',
                'removeIcon' => '<i class="fas fa-times kv-dp-icon"></i>',
                'convertFormat' => false,
                'options' => [
                    'class' => 'form-control underlined'
                ],
                'pluginOptions' => [
                    'format' => 'yyyy-mm-dd',
                    'autoclose'=> true,
                    'minViewMode' => 'days', // months
                    'startView' => 'days',// decade
                ],
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'message')->textarea(['rows' => 6]) ?>
        </div>
    </div>
    <div>
    </div>
    <div class="form-group">
        <?= Html::submitButton($translator->translate('Save'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>