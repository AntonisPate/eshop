<?php

use yii\helpers\Html;

use backend\models\TranslationFactory;

$translatorFactory = new TranslationFactory();
$translator = $translatorFactory->translator;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = $translator->translate('Create Product');
$this->params['breadcrumbs'][] = ['label' => $translator->translate('Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-create">

    <?= $this->render('_form', [
        'model' => $model,
        'product_categories' => $product_categories,
    ]) ?>

</div>
