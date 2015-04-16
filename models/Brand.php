<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "brand".
 *
 * @property integer $id
 * @property string $name
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $create_time
 * @property string $update_time
 *
 * @property Branch[] $branches
 */
class Brand extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $repassword;
    public $oldRecord;
    public $authKey;
    public $products;
    public function afterFind()
    {
                $this->oldRecord=clone $this;
                return parent::afterFind();     
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'brand';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'username', 'password', 'email', 'create_time', 'update_time'], 'required'],
            [['password'], 'validatePasswordForm'],
            [['password', 'repassword'], 'string', 'min'=>8],
            [['email'], 'email'],
            [['create_time', 'update_time'], 'safe'],
            [['name', 'username'], 'string', 'max' => 100],
            [['email'], 'string', 'max' => 150]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'username' => 'Username',
            'password' => 'Password',
            'repassword' => 'Re-Password',
            'email' => 'Email',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranches()
    {
        return $this->hasMany(Branch::className(), ['brand_id' => 'id']);
    }

     /**
     * @return \yii\db\ActiveQuery
     */
    public function getBillInfo()
    {
        return $this->hasOne(BillInfo::className(), ['brand_id' => 'id']);
    }

    

    public function validatePasswordForm()
    {
         if($this->isNewRecord)
        {
            if($this->repassword != $this->password)
                 $this->addError('password','Password and repassword is not match');
        }
    }

    public function beforeSave($insert)
    {
        if($this->isNewRecord || (!$this->isNewRecord && $this->oldRecord->password != $this->password))
        {
            $hash = Yii::$app->getSecurity()->generatePasswordHash($this->password);
            $this->password = $hash;
            return parent::beforeSave($insert);
        }else
            return parent::beforeSave($insert);

    }

    public function validatePassword($password)
    {

        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }


     /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        //return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
        return self::find()->where(["id" => $id])->one();
    }

    
    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        /*foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }*/

        return static::findOne(['access_token' => $token]);
    }

      /**
     * Generates "remember me" authentication key
     */

    public function generateAuthKey()
    {

        $this->authKey = Security::generateRandomKey();

    }


     /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        //return $this->authKey === $authKey;
        return $this->getAuthKey() == $authKey;
    }
    
}
