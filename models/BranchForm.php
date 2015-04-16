<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\Session;

/**
 * BranchForm is the model behind the login form.
 */
class BranchForm extends Model
{
    public $branch_id;
    public $password;
    

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            
            [['branch_id', 'password'], 'required'],
            // rememberMe must be a boolean value
        ];
    }

     /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'branch_id' => 'สาขา',
            'password' => 'รหัสสาขา'
        ];
    }

    public function login()
    {
        $branch = Branch::findOne($this->branch_id);
        if($branch !== null && $branch->password == $this->password)
        {
            return $branch;
        }
        return false;

    }


}
