<?php
/**
 * Created by PhpStorm.
 * User: ManTran
 * Date: 6/24/2015
 * Time: 3:16 PM
 */

namespace backend\assets;

use yii\web\AssetBundle;
use Yii;

// set @themes alias so we do not have to update baseUrl every time we change themes
Yii::setAlias('@themes', Yii::$app->view->theme->baseUrl);

/**
 * Class ArrangementAsset
 * @package backend\assets
 */
class WatermaskAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@themes';

    public $css = [

    ];
    public $js = [
        'js/vendor/fabric.min.js',
        'js/watermask.min.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'backend\assets\AppAsset'
    ];
}