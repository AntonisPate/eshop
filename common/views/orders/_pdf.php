<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\TranslationFactory;

$translatorFactory = new TranslationFactory();
$translator = $translatorFactory->translator;

?>

<div>
    <h2> <strong><?= $translator->translate('Order') . " " . $model->id ?> </strong> </h2>
    <?= $model->formattedDate ?>
    <br>
    <?= $model->statusType ?>
</div>

<div>
    <h2> <strong><?= $translator->translate('Buyer Information') ?> </strong> </h2>
</div>
<table cellpadding="0" cellspacing="0" style="page-break-inside:always; margin-top:0px;  border: none; border-collapse: collapse; width: 100%">
    <tr>
        <td style="font-family: 'arial'; font-size: 13px; width:200px">
            <?= $translator->translate('Name')  ?>
        </td>
        <td style="font-family: 'arial'; font-size: 13px;">
            <?= $model->userFullname ?>
        </td>
    </tr>
    <tr>
        <td style="font-family: 'arial'; font-size: 13px;">
            <?= $translator->translate('Address')  ?>
        </td>
        <td style="font-family: 'arial'; font-size: 13px;">
            <?= $model->address ?>
        </td>
    </tr>
    <tr>
        <td style="font-family: 'arial'; font-size: 13px;">
            <?= $translator->translate('City')  ?>
        </td>
        <td style="font-family: 'arial'; font-size: 13px;">
            <?= $model->city ?>
        </td>
    </tr>
    <tr>
        <td style="font-family: 'arial'; font-size: 13px;">
            <?= $translator->translate('Postal Code')  ?>
        </td>
        <td style="font-family: 'arial'; font-size: 13px;">
            <?= $model->postal_code ?>
        </td>
    </tr>
</table>

<div>
    <h2> <strong><?= $translator->translate('Contact Information') ?> </strong> </h2>
</div>
<table cellpadding="0" cellspacing="0" style="page-break-inside:always; margin-top:0px;  border: none; border-collapse: collapse; width: 100%">
    <tr>
        <td style="font-family: 'arial'; font-size: 13px; width:200px">
            <?= $translator->translate('Phone Number')  ?>
        </td>
        <td style="font-family: 'arial'; font-size: 13px;">
            <?= $model->phone_number ?>
        </td>
    </tr>
    <tr>
        <td style="font-family: 'arial'; font-size: 13px;">
            <?= $translator->translate('Email')  ?>
        </td>
        <td style="font-family: 'arial'; font-size: 13px;">
            <?= $model->email ?>
        </td>
    </tr>
</table>

<div>
    <h2> <strong><?= $translator->translate('Payment Information') ?> </strong> </h2>
</div>
<table cellpadding="0" cellspacing="0" style="page-break-inside:always; margin-top:0px;  border: none; border-collapse: collapse; width: 100%">
    <tr>
        <td style="font-family: 'arial'; font-size: 13px; width:200px">
            <?= $translator->translate('Payment Type')  ?>
        </td>
        <td style="font-family: 'arial'; font-size: 13px;">
            <?= $model->paymentType ?>
        </td>
    </tr>
    <tr>
        <td style="font-family: 'arial'; font-size: 13px;">
            <?= $translator->translate('Transmition Type')  ?>
        </td>
        <td style="font-family: 'arial'; font-size: 13px;">
            <?= $model->transmiType ?>
        </td>
    </tr>
</table>

<div>
    <h2> <strong><?= $translator->translate('Products') ?> </strong> </h2>
</div>

<table cellpadding="0" cellspacing="0" style="page-break-inside:always; margin-top:0px; border: none; border-collapse: collapse;">
    <?php foreach($model->products as $key => $product) { ?>
        <tr>
            <td style="font-family: 'arial'; font-size: 13px; width:300px">
                <?= $product->pdfTitle ?>
            </td>
            <td style="font-family: 'arial'; font-size: 13px; width:100px">
                x <?= $model->getQuantityByProduct($product) ?>
            </td>
            <td style="font-family: 'arial'; font-size: 13px; width:10px; text-align: right;">
                <?= number_format((float)$model->getQuantityByProduct($product) * $product->totalPrice, 2, '.', '');  ?>
            </td>
        </tr>
    <?php } ?>
    <tr>
        <td style="font-family: 'arial'; font-size: 13px; width:1px">

        </td>
        <td style="font-family: 'arial'; font-size: 13px; width:1px">
            <strong><?= $translator->translate('Total Price')  ?></strong>
        </td>
        <td style="font-family: 'arial'; font-size: 13px; width:10px; text-align: right;">
        <strong><?=  number_format($model->totalPrice, 2, '.', ''); ?></strong>
        </td>
    </tr>
</table>