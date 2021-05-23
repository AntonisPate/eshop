<?php
namespace backend\models;

use Yii;
use yii\base\BaseObject;
use kartik\mpdf\Pdf;


class OrderPdf extends BaseObject
{
    private $order;

    public function __construct($order)
    {
        $this->setOrder($order);
        parent::__construct([]);
    }

    public function getOrder()
    {
        return $this->order;
    }

    private function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    public function generate($save = false, $filename = '')
    {
        $session = Yii::$app->session;
        if (isset($session['language'])) {
            \Yii::$app->language = $session['language'];
        } else {
            \Yii::$app->language = 'el';
        }
        $model = $this->getOrder();
        $controller = Yii::$app->controller;

        $pdf = new Pdf([
            'cssInline' => 'figure.table tbody tr td{border-top:none; font-size:13px; line-height:140%; margin-top:10px; width:100%; page-break-inside:avoid; padding:11px 0px -8px 1px; autosize="1"}',
        ]);

        

        $pdf->defaultFont = 'arial';
        $pdf->filename = "Order_".$model->id.".pdf";

        $pdf->methods = [
            // 'SetHTMLHeader' => $this->showHeader ? $controller->renderPartial('@common/views/invoices/_header_pdf', [
            //     'ownerCompany' => $owner,
            //     'sendToAccountant' => $this->sendToAccountant
            // ]) : '',
            // 'SetHTMLFooter' => $this->showFooter ? $controller->renderPartial('@common/views/invoices/_footer_pdf', [
            //     'ownerCompany' => $owner,
            //     'sendToAccountant' => $this->sendToAccountant
            // ]) : '',
        ];

        $directory = '@common/views/orders/';
        $view = '_pdf';

        $pdf->content = $controller->renderPartial($directory.$view, [
            'model' => $model
        ]);

        $pdf->options = [
            'title' => $model->id,
            'keepColumns' => true,
            'setAutoTopMargin' => 'pad', //prevent overlap for header with content
            'setAutoBottomMargin' => 'pad', //prevent overlap for footer with content
        ];

        return $pdf->render();
    }
}