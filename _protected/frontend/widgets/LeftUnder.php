<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 10/19/2015
 * Time: 2:23 PM
 */

namespace frontend\widgets;

use common\models\Category;
use yii\base\Widget;

/**
 * Class LeftUnder
 * @package frontend\widgets
 */
class LeftUnder extends Widget
{
    public function init() {
        parent::init();
    }

    public function run() {
        return $this->render('left-under', [
            'treeCategory' => Category::getTree()
        ]);
    }
}