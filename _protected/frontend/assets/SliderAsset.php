<?php
/**
 * Created by PhpStorm.
 * User: ManTran
 * Date: 6/29/2015
 * Time: 11:24 AM
 */

namespace frontend\assets;

use yii\web\AssetBundle;
use Yii;

// set @themes alias so we do not have to update baseUrl every time we change themes
Yii::setAlias('@themes', Yii::$app->view->theme->baseUrl);

/**
 * Class ProductAsset
 * @package frontend\assets
 */
class SliderAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@themes';

    public $css = [
        "css/lib/slick.css",
    ];
    public $js = [
        "js/lib/slick.min.js",
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'frontend\assets\AppAsset'
    ];
}