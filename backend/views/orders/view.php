<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\TranslationFactory;

$translatorFactory = new TranslationFactory();
$translator = $translatorFactory->translator;
 
?>

<div class="orders-index">
    <div class="card fullscreen-container">
        <div class="card-block mt-2">
            <div class="tab-content">
                <div class="row">
                    <div class="col-md-6">
                        <?php foreach($model->products as $key => $product) { ?>
                            <div class="row">
                                <dt class="col-md-9"><?= Yii::$app->language == 'el' ? $product->title : $product->english_title ?>:</dt>
                                <dd class="col-md-3">
                                    <?= 'x ' .$model->getQuantityByProduct($product) ?>
                                </dd>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <dt class="col-md-7"><?= $translator->translate('Name') ?>:</dt>
                            <dd class="col-md-5">
                                <?= $model->name ?>
                            </dd>
                        </div>
                        <div class="row">
                            <dt class="col-md-7"><?= $translator->translate('Surname')  ?>:</dt>
                            <dd class="col-md-5">
                                <?= $model->surname ?>
                            </dd>
                        </div>
                        <div class="row">
                            <dt class="col-md-7"><?= $translator->translate('Address')  ?>:</dt>
                            <dd class="col-md-5">
                                <?= $model->address ?>
                            </dd>
                        </div>
                        <div class="row">
                            <dt class="col-md-7"><?= $translator->translate('City')  ?>:</dt>
                            <dd class="col-md-5">
                                <?= $model->city ?>
                            </dd>
                        </div>
                        <div class="row">
                            <dt class="col-md-7"><?= $translator->translate('Postal Code')  ?>:</dt>
                            <dd class="col-md-5">
                                <?= $model->postal_code ?>
                            </dd>
                        </div>
                        <div class="row">
                            <dt class="col-md-7"><?= $translator->translate('Email')  ?>:</dt>
                            <dd class="col-md-5">
                                <?= $model->email ?>
                            </dd>
                        </div>
                        <div class="row">
                            <dt class="col-md-7"><?= $translator->translate('Phone Number')  ?>:</dt>
                            <dd class="col-md-5">
                                <?= $model->phone_number ?>
                            </dd>
                        </div>
                        <div class="row">
                            <dt class="col-md-7"><?= $translator->translate('Date')  ?>:</dt>
                            <dd class="col-md-5">
                                <?= $model->date ?>
                            </dd>
                        </div>
                        <div class="row">
                            <dt class="col-md-7"><?= $translator->translate('Status')  ?>:</dt>
                            <dd class="col-md-5">
                                <?= $model->statusType ?>
                            </dd>
                        </div>
                        <div class="row">
                            <dt class="col-md-7"><?= $translator->translate('Payment')  ?>:</dt>
                            <dd class="col-md-5">
                                <?= $model->paymentType ?>
                            </dd>
                        </div>
                        <div class="row">
                            <dt class="col-md-7"><?= $translator->translate('Transmition Type')  ?>:</dt>
                            <dd class="col-md-5">
                                <?= $model->transmiType ?>
                            </dd>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h3><?= $translator->translate('Total Price') ?></h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?= $model->totalPrice . ' €'?> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>