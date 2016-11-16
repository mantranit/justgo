<?php
/**
 * Created by PhpStorm.
 * User: tdmman
 * Date: 4/29/2015
 * Time: 11:19 AM
 */

namespace frontend\assets;

use yii\web\AssetBundle;
use Yii;

// set @themes alias so we do not have to update baseUrl every time we change themes
Yii::setAlias('@themes', Yii::$app->view->theme->baseUrl);

/**
 * Class SearchAsset
 * @package frontend\assets
 */
class SearchAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@themes';

    public $css = [

    ];
    public $js = [

    ];

    public $depends = [
        'yii\web\YiiAsset',
        'frontend\assets\AppAsset'
    ];
}