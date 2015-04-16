<?php

namespace app\controllers;

use Yii;
use app\models\Brand;
use yii\rest\ActiveController;

/**
 * BrandController implements the CRUD actions for Brand model.
 */
class ServiceController extends ActiveController
{
    public $modelClass = 'app\models\Brand';
}
