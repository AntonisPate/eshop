<?php
    use yii\web\JsExpression;
    use richardfan\widget\JSRegister;
    use yii\helpers\Url;
    use yii\helpers\Html;
    use backend\models\TranslationFactory;

    $translatorFactory = new TranslationFactory();
    $translator = $translatorFactory->translator;

    $this->title = $translator->translate($product_category->primary_name); 
?>

<div class="row" style="margin-top: 10px;">
    <div class="col-md-11">
        <?= $this->render('/vue-components/_product_component',
            [
                'url' => $url,
            ])
        ?>
    </div>
</div>

<?php JSRegister::begin([
    'position' => \yii\web\View::POS_READY
]); ?>
    <script>  
    </script>
 <?php JSRegister::end(); ?>