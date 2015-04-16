<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use Yii;
use yii\console\Controller;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $manageSystem = $auth->createPermission('manageSystem');
        $manageSystem->description = 'Manage System';
        $auth->add($manageSystem);
        //manageBrand
        $manageBrand = $auth->createPermission('manageBrand');
        $manageBrand->description = 'Manage brand';
        $auth->add($manageBrand);

        // add "updatePost" permission
        $manageStore = $auth->createPermission('manageStore');
        $manageStore->description = 'Manage Store';
        $auth->add($manageStore);

        $usePos = $auth->createPermission('usePos');
        $usePos->description = 'use Pos system';
        $auth->add($usePos);

        // add "author" role and give this role the "createPost" permission
        $employee = $auth->createRole('employee');
        $auth->add($employee);
        $auth->addChild($employee, $usePos);

        $manager = $auth->createRole('manager');
        $auth->add($manager);
        $auth->addChild($manager, $usePos);
        $auth->addChild($manager, $manageStore);

        $brand_owner = $auth->createRole('brandOwner');
        $auth->add($brand_owner);
        $auth->addChild($brand_owner, $usePos);
        $auth->addChild($brand_owner, $manageStore);
        $auth->addChild($brand_owner, $manageBrand);

        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "author" role
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $usePos);
        $auth->addChild($admin, $manageStore);
        $auth->addChild($admin, $manageBrand);
        $auth->addChild($admin, $manageSystem);
        

        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
      
    }
}
