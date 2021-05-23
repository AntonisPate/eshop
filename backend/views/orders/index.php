<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\TranslationFactory;
use backend\models\Order;
use yii\web\JsExpression;
use richardfan\widget\JSRegister;
use backend\helpers\ChartHelper;

$translatorFactory = new TranslationFactory();
$translator = $translatorFactory->translator;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<div class="orders-index">
    <div class="card fullscreen-container">
        <ul class="nav nav-tabs pull-right" role="tablist">
            <li class="nav-item">
                <a class="nav-link <?= $tab =='gridview' ?  'active' : ''?>" href='<?= Url::to(["/orders/index/","tab" => 'gridview'])?>' role="tab">
                    <?=  $translator->translate('Gridview') ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $tab =='statistics' ?  'active' : ''?>" href='<?= Url::to(["/orders/index/","tab" => 'statistics'])?>' role="tab" >
                    <?= $translator->translate('Statistics') ?>
                </a>
            </li>
        </ul>
        <div class="card-block mt-2">
            <div class="tab-content">
                <?php Pjax::begin(); ?>
                    <?php if ($tab == "gridview") { ?>
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'options' => [
                                'class' => 'table table-hover'
                            ],
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                [
                                    'attribute' => 'user_id',
                                    'label' => $translator->translate('User'),
                                    'format' => 'raw',
                                    'value' => function($model) {
                                        return $model->userFullname;
                                    },
                                ],
                                [
                                    'attribute' => 'transmit_type',
                                    'label' => $translator->translate('Transmition Type'),
                                    'format' => 'raw',
                                    'value' => function($model) {
                                        return $model->transmiType;
                                    },
                                ],
                                [
                                    'attribute' => 'pay_by',
                                    'label' => $translator->translate('Payment'),
                                    'format' => 'raw',
                                    'value' => function($model) {
                                        return $model->paymentType;
                                    },
                                ],
                                [
                                    'attribute' => 'status',
                                    'label' => $translator->translate('Status'),
                                    'format' => 'raw',
                                    'value' => function($model) {
                                        return $model->statusType;
                                    },
                                ],
                                [
                                    'attribute' => 'data',
                                    'label' => $translator->translate('Date'),
                                    'format' => 'raw',
                                    'value' => function($model) {
                                        return $model->formattedDate;
                                    },
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => '<div class="btn-group">{view} {delete} {set-sent} {set-delivered} {set-cancelled} {set-completed} {pdf} </div>',
                                    'contentOptions' => ['style' => 'white-space: nowrap'],
                                    'footerOptions' => ['hidden' => true],
                                    'buttons' => [
                                        'set-sent' => function($url, $model, $key) {
                                                $translatorFactory = new TranslationFactory();
                                                $translator = $translatorFactory->translator;
                                                return $model->status < Order::STATUS_SENT ? Html::a('<i class="fa fa-paper-plane"></i>',
                                                    ['/orders/set-send', 'id' => $model->id], [
                                                    'data-pjax' => '0',
                                                    'data-toggle' => 'tooltip',
                                                    'title' => $translator->translate('Set Send')
                                            ]) : '';
                                        },
                                        'set-delivered' => function($url, $model, $key) {
                                                $translatorFactory = new TranslationFactory();
                                                $translator = $translatorFactory->translator;
                                                return $model->status < Order::STATUS_DELIVERED ? Html::a('<i class="fa fa-user"></i>',
                                                    ['/orders/set-delivered', 'id' => $model->id], [
                                                    'data-pjax' => '0',
                                                    'data-toggle' => 'tooltip',
                                                    'title' => $translator->translate('Set Delivered')
                                            ]) : '';
                                        },
                                        'set-cancelled' => function($url, $model, $key) {
                                                $translatorFactory = new TranslationFactory();
                                                $translator = $translatorFactory->translator;
                                                return $model->status != Order::STATUS_COMPLETED && $model->status != Order::STATUS_CANCELLED ? Html::a('<i class="fa fa-trash"></i>',
                                                    ['/orders/set-cancelled', 'id' => $model->id], [
                                                    'data-pjax' => '0',
                                                    'data-toggle' => 'tooltip',
                                                    'title' => $translator->translate('Set Cancelled')
                                            ]) : '';
                                        },
                                        'set-completed' => function($url, $model, $key) {
                                                $translatorFactory = new TranslationFactory();
                                                $translator = $translatorFactory->translator;
                                                return $model->status != Order::STATUS_COMPLETED && $model->status != Order::STATUS_CANCELLED ? Html::a('<i class="fa fa-check"></i>',
                                                    ['/orders/set-completed', 'id' => $model->id], [
                                                    'data-pjax' => '0',
                                                    'data-toggle' => 'tooltip',
                                                    'title' => $translator->translate('Set Completed')
                                            ]) : '';
                                        },
                                        'pdf' => function($url, $model, $key) {
                                            $translatorFactory = new TranslationFactory();
                                            $translator = $translatorFactory->translator;
                                            return Html::a('<i class="fa fa-download"></i>',
                                                ['/orders/pdf', 'id' => $model->id], [
                                                'data-pjax' => '0',
                                                'data-toggle' => 'tooltip',
                                                'title' => $translator->translate('Download Pdf')
                                            ]);
                                    }
                                    ]
                                ]
                            ],
                        ]); ?>
                    <?php } ?>
                    <?php if ($tab == "statistics") { ?>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3> <?= $translator->translate('Per Status') ?> </h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-12">
                                            <canvas id="typeChart" width="400" height="400" style=" "></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3> <?= $translator->translate('Per User') ?> </h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-12">
                                            <canvas id="userChart" width="400" height="400" style=" "></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>

<?php JSRegister::begin([
    'position' => \yii\web\View::POS_READY
]); ?>
    <script>
        var ctx = document.getElementById('typeChart');
        var userChartctx = document.getElementById('userChart');
        var typeChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: [
                '<?= Order::getStatusNameById(Order::STATUS_RECEIVED) ?>',
                '<?= Order::getStatusNameById(Order::STATUS_SENT) ?>',
                '<?= Order::getStatusNameById(Order::STATUS_DELIVERED) ?>',
                '<?= Order::getStatusNameById(Order::STATUS_CANCELLED) ?>',
                '<?= Order::getStatusNameById(Order::STATUS_COMPLETED) ?>',
                ],
                datasets: [{
                    label: '<?= $translator->translate('Per Status') ?>',
                    data: [
                        <?= $receivedData ?>, 
                        <?= $sentdData ?>, 
                        <?= $deliveredData ?>, 
                        <?= $cancelledData ?>, 
                        <?= $completedData ?>
                    ],
                    backgroundColor: [
                        'rgba(155, 99, 232, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(0, 0, 255, 0.5)',
                        'rgba(255, 0, 0, 0.5)',
                        'rgba(0, 255, 0, 0.5)'
                    ],
                    borderColor: [
                        'rgba(155, 99, 232, 0.1)',
                        'rgba(54, 162, 235, 0.1)',
                        'rgba(0, 0, 255, 0.1)',
                        'rgba(255, 0, 0, 0.1)',
                        'rgba(0, 255, 0, 0.1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: { 
            }
        });

        var userLabels = <?= ChartHelper::getUserLabels() ?>;
        var userData = <?= ChartHelper::getUserData() ?>;
        var userColors = <?= ChartHelper::getUserColors() ?>;
        var userBorderColor = <?= ChartHelper::getUserBorderColors() ?>;
        var userChart = new Chart(userChartctx, {
            type: 'pie',
            data: {
                labels: userLabels,
                datasets: [{
                    label: '<?= $translator->translate('Per User') ?>',
                    data: userData,
                    backgroundColor: userColors,
                    borderColor: userBorderColor,
                    borderWidth: 1
                }]
            },
            options: {
                
            }
        });
    </script>
<?php JSRegister::end(); ?>