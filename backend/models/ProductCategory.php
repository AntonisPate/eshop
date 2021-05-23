<?php
namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

use backend\models\TranslationFactory;

/**
 * Product model
 *
 * @property integer $id
 * @property string $primary_name
 * @property string $shortname
 * @property integer $discount_id
 * @property text $description
 */
class ProductCategory extends ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_category';
    }
    

    public static function getAvailable()
    {
        $categories = ProductCategory::find()->all();

        $out = [];
        
        if(!empty($categories)) {
            foreach($categories as $key => $category) {
                $out [] = $category->shortname;
            }
        }

        return $out;
    }

    public static function getDropDownOptions()
    {
       
        $translatorFactory = new TranslationFactory();
        $translator = $translatorFactory->translator;
        $categories = ProductCategory::find()->all();

        $out = [];
    
        foreach ($categories as $key => $category) {
            if ($category->sub_category_id != null) {
                $mainCategory = ProductCategory::findOne($category->sub_category_id);
                $out [$translator->translate($mainCategory->primary_name)] [$category->id] = $translator->translate($category->primary_name);
            } else {
                $mainCategory = ProductCategory::findOne($category->id);
                $out [$translator->translate($mainCategory->primary_name)] [$category->id] = $translator->translate($category->primary_name);
            }
        }
        return $out;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'number'],
            [['primary_name', 'shortname', 'description'], 'string'],
        ];
    }

    public function getSubCategories()
    {
        if ($this->sub_category_id == null) {
            return ProductCategory::find('id')
                    ->where(['sub_category_id' => $this->id])
                    ->orWhere(['id' => $this->id])
                    ->all();
        }
    }

    public function getSubCategoriesIds()
    {
        $out = [];
        if ($this->sub_category_id == null) {
            $subCategories = ProductCategory::find('id')
                    ->where(['sub_category_id' => $this->id])
                    ->orWhere(['id' => $this->id])
                    ->all();
            
            if (!empty($subCategories)) {
                foreach($subCategories as $key => $subCategory) {
                    $out [] = $subCategory->id;
                }
                return $out;
            }
        }
        return out;
    }

    /**
     * {@inheritdoc}
     * @return ProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductCategoryQuery(get_called_class());
    }
}