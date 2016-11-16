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
class ArrangementAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@themes';

    public $css = [

    ];
    public $js = [
        'js/vendor/jquery.sortable.min.js',
        'js/arrangement.min.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'backend\assets\AppAsset'
    ];
}