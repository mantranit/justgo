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
 * Class ProductAsset
 * @package backend\assets
 */
class ProductAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@themes';

    public $css = [

    ];
    public $js = [
        'plupload/plupload.full.min.js',
        'textext/js/textext.core.js',
        'textext/js/textext.plugin.autocomplete.js',
        'textext/js/textext.plugin.tags.js',
        'js/vendor/jquery.sortable.min.js',
        'js/vendor/jquery.cookie.js',
        'js/vendor/jquery-ui.core.min.js',
        'js/vendor/jquery.dynatree.min.js',
        'js/vendor/jquery.maskMoney.min.js',
        'js/vendor/jquery.fancybox.pack.js',
        'js/global.min.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'backend\assets\AppAsset'
    ];
}