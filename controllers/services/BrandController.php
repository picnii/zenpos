<?php

namespace app\controllers\services;

use Yii;
use app\models\Brand;
use yii\rest\ActiveController;

/**
 * BrandController implements the CRUD actions for Brand model.
 */
class BrandController extends ActiveController
{
    public $modelClass = 'app\models\Brand';
}
