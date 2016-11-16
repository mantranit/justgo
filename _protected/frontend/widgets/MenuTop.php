<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 10/16/2015
 * Time: 1:24 PM
 */

namespace frontend\widgets;

use yii\base\Widget;

/**
 * Class MenuTop
 * @package frontend\widgets
 */
class MenuTop extends Widget
{
    public function init() {
        parent::init();
    }

    public function run() {
        return $this->render('menu-top');
    }
}