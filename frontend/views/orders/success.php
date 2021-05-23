<?php
    use kartik\select2\Select2;
    use yii\web\JsExpression;
    use richardfan\widget\JSRegister;
    use yii\helpers\Url;
    use yii\helpers\Html;
    use backend\models\TranslationFactory;

    $translatorFactory = new TranslationFactory();
    $translator = $translatorFactory->translator;
?>

<div class="ordersDiv">
    <div class="row">
        <div class="col-md-12">
            <h3> <?= $translator->translate('Success') ?> </h3>
        </div>
    </div>
    <div class="row" style="margin-top: 5%;">
        <div class="col-md-12">
            <p> <?= $translator->translate('Your order has been complete successfully') ?> </p>
        </div>
    </div>
</div>