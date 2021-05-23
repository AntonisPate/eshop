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
                                'attribute' => 'user',
                                'label' => $translator->translate('User'),
                                'format' => 'raw',
                                'value' => function($model) {
                                    return $model->user_fullname;
                                },
                            ],
                            [
                                'attribute' => 'content',
                                'label' => $translator->translate('Content'),
                                'format' => 'raw',
                                'value' => function($model) {
                                    return $model->content;
                                },
                            ],
                            [
                                'attribute' => 'stars',
                                'label' => $translator->translate('Stars'),
                                'format' => 'raw',
                                'value' => function($model) {
                                    return $model->stars;
                                },
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '<div class="btn-group">{delete}</div>',
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
