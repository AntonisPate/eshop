<?php

use yii\helpers\Html;

use backend\models\TranslationFactory;

$translatorFactory = new TranslationFactory();
$translator = $translatorFactory->translator;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = Yii::t('app', 'Update Product: {name}', [
    'name' => $model->title,
]);
$this->params['breadcrumbs'][] = ['label' => $translator->translate('Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $translator->translate('Update');
?>
<div class="product-update">

    <?= $this->render('_form', [
        'model' => $model,
        'product_categories' => $product_categories,
        'discounts' => $discounts
    ]) ?>

</div>
