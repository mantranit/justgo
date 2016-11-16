<?php
/**
 * Created by PhpStorm.
 * User: ManTran
 * Date: 6/17/2015
 * Time: 5:58 PM
 */

namespace backend\assets;

use yii\web\AssetBundle;
use Yii;

// set @themes alias so we do not have to update baseUrl every time we change themes
Yii::setAlias('@themes', Yii::$app->view->theme->baseUrl);

/**
 * Class PageBuilderAsset
 * @package backend\assets
 */
class PageBuilderAsset extends AssetBundle
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
        'js/vendor/colpick.js',
        'js/page-builder.min.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'backend\assets\AppAsset'
    ];
}