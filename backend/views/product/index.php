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
            <a class="nav-link  <?= $category =='seeds' ?  'active' : ''?>" href='<?= Url::to(["/product/index/","category" => 'seeds'])?>' role="tab" >
                <?=  $translator->translate('Seeds') ?>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $category =='fertilizers' ?  'active' : ''?>" href='<?= Url::to(["/product/index/","category" => 'fertilizers'])?>' role="tab" >
                <?= $translator->translate('Fertilizers') ?>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $category =='plants trees' ?  'active' : ''?>" href='<?= Url::to(["/product/index/","category" => 'plants trees'])?>' role="tab" >
                <?= $translator->translate('Plants Trees') ?>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $category =='garden equipment' ?  'active' : ''?>" href='<?= Url::to(["/product/index/","category" => 'garden equipment'])?>' role="tab" >
                <?= $translator->translate('Garden Equipment') ?>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $category =='protection equipment' ?  'active' : ''?>" href='<?= Url::to(["/product/index/","category" => 'protection equipment'])?>' role="tab" >
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
                        <?= Html::a($translator->translate('Create Product'), ['create'], ['class' => 'btn btn-success']) ?>
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
                        'options' => [
                            'class' => 'table table-hover'
                        ],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'attribute' => 'title',
                                'label' => $translator->translate('Title'),
                                'format' => 'raw',
                                'value' => function($model) {
                                    return $model->title;
                                },
                            ],
                            [
                                'attribute' => 'price',
                                'label' => $translator->translate('Price'),
                                'format' => 'raw',
                                'value' => function($model) {
                                    return $model->getPrice() . ' €';
                                },
                            ],
                            [
                                'attribute' => 'description',
                                'label' => $translator->translate('Description'),
                                'format' => 'raw',
                                'value' => function($model) {
                                    return $model->description;
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
                                'attribute' => 'discount',
                                'label' => $translator->translate('Discounts'),
                                'format' => 'raw',
                                'value' => function($model) {
                                    $out = '';
                                    $discounts = $model->discounts;
                                    if (!empty($discounts)) {
                                        foreach($discounts as $discount) {
                                            $out .= '<a  
                                                href="'.Url::to(["/discounts/view", 'id' => $discount->id]).'">'
                                                . $discount->title . '</a>' .  "<br>";
                                        }
                                    }
                                    return $out;
                                },
                            ],
                            [
                                'attribute' => 'rating',
                                'label' => $translator->translate('Rating'),
                                'format' => 'raw',
                                'value' => function($model) {
                                    return $model->rating;
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
