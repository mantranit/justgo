<?php
/**
 * Created by PhpStorm.
 * User: Jimmy
 * Date: 3/24/2015
 * Time: 6:02 PM
 */

namespace backend\assets;

use yii\web\AssetBundle;
use Yii;

// set @themes alias so we do not have to update baseUrl every time we change themes
Yii::setAlias('@themes', Yii::$app->view->theme->baseUrl);

/**
 * Class FullAsset
 * @package backend\assets
 */
class FullAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@themes';

    public $css = [
        'css/font-awesome.min.css',
        'css/foundation.min.css',
        'css/login.min.css',

    ];
    public $js = [
        'js/vendor/foundation.min.js',

    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}