<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 10/16/2015
 * Time: 1:30 PM
 */

namespace frontend\widgets;

use common\models\Category;
use yii\base\Widget;

/**
 * Class MenuLeft
 * @package frontend\widgets
 */
class MenuLeft extends Widget
{
    public function init() {
        parent::init();
    }

    public function run() {
        return $this->render('menu-left', [
            'treeCategory' => Category::getTree()
        ]);
    }
}