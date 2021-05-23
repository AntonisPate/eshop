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

?>

<div class="card">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'username')->textInput(['maxlength' => true])->label($translator->translate('Username')) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label($translator->translate('Name')) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'surname')->textInput(['maxlength' => true])->label($translator->translate('Surname')) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true])->label($translator->translate('Email')) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'password')->textInput(['maxlength' => true])->label($translator->translate('Password')) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= 
                $form->field($model, 'user_type')->widget(Select2::classname(), [
                    'data' => $user_roles,
                    'options' => ['prompt' => $translator->translate('Select a Role ...') ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label($translator->translate('User Role'));
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <?= Html::submitButton($translator->translate('Save'), ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>