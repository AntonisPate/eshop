<?php

use yii\helpers\Html;

use backend\models\TranslationFactory;

$translatorFactory = new TranslationFactory();
$translator = $translatorFactory->translator;

/* @var $this yii\web\View */
/* @var $model app\models\Discount */

$this->params['breadcrumbs'][] = ['label' => $translator->translate('Discounts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->discount->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $translator->translate('Update');
?>
<div class="product-update">

    <?= $this->render('_form', [
        'model' => $model,
        'product_categories' => $product_categories
    ]) ?>

</div>
