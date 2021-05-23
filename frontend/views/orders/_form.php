<?php
    use kartik\select2\Select2;
    use yii\web\JsExpression;
    use richardfan\widget\JSRegister;
    use yii\helpers\Url;
    use yii\helpers\Html;
    use backend\models\TranslationFactory;
    use yii\widgets\ActiveForm;
    
    $translatorFactory = new TranslationFactory();
    $translator = $translatorFactory->translator;
?>


<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="ordersDiv">
    <div class="row">
        <div class="col-md-3">
            <h3> <?= $translator->translate('Information') ?> </h3>
        </div>
        <div class="col-md-5">
            <h3> <?= $translator->translate('Transmition Type') ?> </h3>
        </div>
        <div class="col-md-4">
            <h3> <?= $translator->translate('Payment') ?> </h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true])->label($translator->translate('Email')) ?>
        </div>
        <div class="col-md-5" style="margin-top: 0.5%;">
            <?= 
                $form->field($model, 'transmit_type')->widget(Select2::classname(), [
                    'data' => $transmit_types,
                    'options' => ['prompt' => $translator->translate('Select a tranmition type ...')],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'containerCssClass' => 'form-control underlined',
                    ],
                ])->label($translator->translate(' '));
            ?>
        </div>
        <div class="col-md-4">
            <?= 
                $form->field($model, 'pay_by')->widget(Select2::classname(), [
                    'data' => $payment_types,
                    'options' => ['prompt' => $translator->translate('Select a payment type ...')],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'containerCssClass' => 'form-control underlined',
                    ],
                ])->label($translator->translate(' '));
            ?>
        </div>
    </div>    
    <div class="row">
        <div class="col-md-12">
            <h3> <?= $translator->translate('Phone Number') ?> </h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
        <?= $form->field($model, 'phone_number')->textInput(['maxlength' => true])->label($translator->translate('')) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h3> <?= $translator->translate('Shipping Address') ?> </h3>
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
            <?= $form->field($model, 'address')->textInput(['maxlength' => true])->label($translator->translate('Address')) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'city')->textInput(['maxlength' => true])->label($translator->translate('City')) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'postal_code')->textInput(['maxlength' => true])->label($translator->translate('Postal Code')) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?= Html::submitButton($translator->translate('Finish Order'), ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>