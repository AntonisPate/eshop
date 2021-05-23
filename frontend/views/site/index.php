<?php
    use kartik\select2\Select2;
    use yii\web\JsExpression;
    use richardfan\widget\JSRegister;
    use yii\helpers\Url;
    $this->title = 'ESHOP';
    use backend\models\TranslationFactory;

    $translatorFactory = new TranslationFactory();
    $translator = $translatorFactory->translator;
?>

<div class="row" style="margin-top: 10px;">
    <div class="col-md-12">
        <h3><?= $translator->translate('Popular Products') ?> </h3>

    </div>
</div>

<?php JSRegister::begin([
    'position' => \yii\web\View::POS_READY
]); ?>
    <script>

    </script>
 <?php JSRegister::end(); ?>
