<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;

use backend\models\TranslationFactory;

$translatorFactory = new TranslationFactory();
$translator = $translatorFactory->translator;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<div class="product-index">
    <ul class="nav nav-tabs pull-right" role="tablist">
        <li class="nav-item">
            <a class="nav-link  <?= $category =='seeds' ?  'active' : ''?>" href='<?= Url::to(["/discounts/index/","category" => 'seeds'])?>' role="tab" >
                <?= $translator->translate('Seeds') ?>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $category =='fertilizers' ?  'active' : ''?>" href='<?= Url::to(["/discounts/index/","category" => 'fertilizers'])?>' role="tab" >
                <?= $translator->translate('Fertilizers') ?>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $category =='plants trees' ?  'active' : ''?>" href='<?= Url::to(["/discounts/index/","category" => 'plants trees'])?>' role="tab" >
                <?= $translator->translate('Plants Trees') ?>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $category =='garden equipment' ?  'active' : ''?>" href='<?= Url::to(["/discounts/index/","category" => 'garden equipment'])?>' role="tab" >
                <?= $translator->translate('Garden Equipment') ?>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $category =='protection equipment' ?  'active' : ''?>" href='<?= Url::to(["/discounts/index/","category" => 'protection equipment'])?>' role="tab" >
                <?= $translator->translate('Protection Equipment') ?>
            </a>
        </li>
    </ul>
    <div class="card fullscreen-container">
        <div class="card-header bordered">
            <div class="header-block">
                <h3 class="title">
                    <?= Html::encode(strtoupper($translator->translate($category))) ?>
                </h3>
                <div class="card card-block mt-2">
                    <p>
                        <?= Html::a($translator->translate('Create Discount'), ['create'], ['class' => 'btn btn-success']) ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="card-block mt-2">
            <div class="tab-content">
                <div id="fertilizers" role="tabpanel">
                    <?php Pjax::begin(); ?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'attribute' => 'title',
                                'label' => $translator->translate('Τitle'),
                                'format' => 'raw',
                                'value' => function($model) {
                                    return $model->title;
                                },
                            ],
                            [
                                'attribute' => 'category',
                                'label' => $translator->translate('Category'),
                                'format' => 'raw',
                                'value' => function($model) {
                                    return $model->productCategoryName;
                                },
                            ],
                            [
                                'attribute' => 'price',
                                'label' => $translator->translate('Price'),
                                'format' => 'raw',
                                'value' => function($model) {
                                    return Yii::$app->formatter->asPercent($model->getDiscount());
                                },
                            ],
                            [
                                'attribute' => 'message',
                                'label' => $translator->translate('Message'),
                                'format' => 'raw',
                                'value' => function($model) {
                                    return $model->message;
                                },
                            ],
                            [
                                'attribute' => 'from',
                                'label' => $translator->translate('From'),
                                'format' => 'raw',
                                'value' => function($model) {
                                    return $model->getFormattedFromDate();
                                },
                            ],
                            [
                                'attribute' => 'to',
                                'label' => $translator->translate('To'),
                                'format' => 'raw',
                                'value' => function($model) {
                                    return $model->getFormattedToDate();
                                },
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '<div class="btn-group">{update} {delete}</div>',
                                'contentOptions' => ['style' => 'white-space: nowrap'],
                                'footerOptions' => ['hidden' => true],
                            ]
                        ],
                    ]); ?>
                    <?php Pjax::end(); ?>
                </div>
            <div>
        </div>
    </div>
</div>
