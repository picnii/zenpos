<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * WholesalenForm is the model behind the login form.
 */
class WholesaleForm extends Model
{
    public $price_12;
    public $price_36;
    public $price_60;
    public $have_12 = true;
    public $have_36 = false;
    public $have_60 = false;


    private $_whole12, $_whole36, $_whole60;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            ['price_12', 'validatePrice12'],
            ['price_36', 'validatePrice36'],
            ['price_60', 'validatePrice60'],
            [['price_12', 'price_36', 'price_60'], 'integer'],
            // rememberMe must be a boolean value
            [['have_12', 'have_36', 'have_60'], 'boolean'],
        ];
    }

    public function validatePrice12 ($attribute, $params)
    {
        if(!($this->have_12 && $this->price_12 > 0))
            $this->addError($attribute, 'Need to be filled');
    }

    public function validatePrice36 ($attribute, $params)
    {
        if(!($this->have_36 && $this->price_36 > 0))
            $this->addError($attribute, 'Need to be filled');
    }

    public function validatePrice60 ($attribute, $params)
    {
        if(!($this->have_60 && $this->price_60 > 0))
            $this->addError($attribute, 'Need to be filled');
    }

     /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'price_12' => 'Price 1 - 2 โหล',
            'price_36' => 'Price 3 - 4 โหล',
            'price_60' => 'Price 5 โหล ขึ้นไป',
            'have_12' => 'มีราคา 1 - 2 โหลมั้ย',
            'have_36' => 'มีราคา 3 - 4 โหลมั้ย',
            'have_60' => 'มีราคา 5 โหลขึ้นไปมั้ย',
        ];
    }

    public function create($product_id)
    {
        $result = true;
        if($this->have_12)
        {
            $wholesale = new Wholesale();
            $wholesale->product_id = $product_id;
            $wholesale->min_item  = 12;
            $wholesale->price = $this->price_12;
            $result = $result && $wholesale->save();
        }

        if($this->have_36)
        {
            $wholesale = new Wholesale();
            $wholesale->product_id = $product_id;
            $wholesale->min_item  = 36;
            $wholesale->price = $this->price_36;
            $result = $result && $wholesale->save();
        }

        if($this->have_60)
        {
            $wholesale = new Wholesale();
            $wholesale->product_id = $product_id;
            $wholesale->min_item  = 60;
            $wholesale->price = $this->price_60;
            $result = $result && $wholesale->save();
        }

        return $result;

    }

    public function loadWholesale($product_id)
    {
        $_whole12 = Wholesale::find()->where(['product_id'=> $product_id, 'min_item' => 12])->one();
        $_whole36 = Wholesale::find()->where(['product_id'=> $product_id, 'min_item' => 36])->one();
        $_whole60 = Wholesale::find()->where(['product_id'=> $product_id, 'min_item' => 60])->one();
        if($_whole12 !== null)
        {
            $this->price_12 = $_whole12->price;
            $this->have_12 = true;
        }
        if($_whole36 !== null)
        {
            $this->price_36 = $_whole36->price;
            $this->have_36 = true;
        }
        if($_whole60 !== null)
        {
            $this->price_60 = $_whole60->price;
            $this->have_60 = true;
        }
    }


    public function update($product_id)
    {
        $_whole12 = Wholesale::find()->where(['product_id'=> $product_id, 'min_item' => 12])->one();
        $_whole36 = Wholesale::find()->where(['product_id'=> $product_id, 'min_item' => 36])->one();
        $_whole60 = Wholesale::find()->where(['product_id'=> $product_id, 'min_item' => 60])->one();
        if($_whole12 !== null)
            $_whole12->delete();
        if($_whole36 !== null)
            $_whole36->delete();
        if($_whole60 !== null)
            $_whole60->delete();
        return $this->create($product_id);
    }


}
