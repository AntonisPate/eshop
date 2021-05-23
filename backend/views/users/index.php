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

<div class="reviews-index">
    <div class="card fullscreen-container">
        <div class="card-header bordered">
            <div class="header-block">
                <div class="card card-block mt-2">
                    <p>
                        <?= Html::a($translator->translate('Create User'), ['create'], ['class' => 'btn btn-success']) ?>
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
                                'attribute' => 'name',
                                'label' => $translator->translate('Name'),
                                'format' => 'raw',
                                'value' => function($model) {
                                    return $model->name;
                                },
                            ],
                            [
                                'attribute' => 'surname',
                                'label' => $translator->translate('Surname'),
                                'format' => 'raw',
                                'value' => function($model) {
                                    return $model->surname;
                                },
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '<div class="btn-group">{delete} {update} </div>',
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
