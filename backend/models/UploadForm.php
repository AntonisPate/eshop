<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }
    
    public function upload($product_id)
    {
        if ($this->validate()) {
            if ( file_exists(Yii::$app->basePath . '/web/uploads/' . $product_id.'.jpg') ) {
                unlink(Yii::$app->basePath . '/web/uploads/' . $product_id.'.jpg');
            } else if (file_exists(Yii::$app->basePath . '/web/uploads/' . $product_id.'.png')) {
                unlink(Yii::$app->basePath . '/web/uploads/' . $product_id.'.png');
            }
            if ($this->imageFile != null) {
                $this->imageFile->saveAs('uploads/' . $product_id . '.' . $this->imageFile->extension);
            }
        }
        return true;
    }
}