<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 10/22/2015
 * Time: 1:57 PM
 */

namespace backend\assets;

use yii\web\AssetBundle;
use Yii;

// set @themes alias so we do not have to update baseUrl every time we change themes
Yii::setAlias('@themes', Yii::$app->view->theme->baseUrl);

/**
 * Class SystemAsset
 * @package backend\assets
 */
class SystemAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@themes';

    public $css = [

    ];
    public $js = [
        'js/vendor/jquery-ui.sortable.min.js',
        //'js/vendor/jquery.sortable.min.js',
        'js/system.min.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'backend\assets\AppAsset'
    ];
}