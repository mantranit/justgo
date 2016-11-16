<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 10/16/2015
 * Time: 1:31 PM
 */

namespace frontend\widgets;

use common\models\Category;
use yii\base\Widget;

/**
 * Class MenuBottom
 * @package frontend\widgets
 */
class MenuBottom extends Widget
{
    public function init() {
        parent::init();
    }

    public function run() {
        return $this->render('menu-bottom', [
            'treeCategory' => Category::getTree()
        ]);
    }
}