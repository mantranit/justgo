<?php
/**
 * Created by PhpStorm.
 * User: ManTran
 * Date: 7/1/2015
 * Time: 3:16 PM
 */

use common\models\Config;

/* @var $this yii\web\View */
/* @var $model common\models\Content */

$this->title = !empty($model->seo_title) ? $model->seo_title : $model->name . ' | ' . Config::findOne(['key' => 'SEO_TITLE'])->value;
$this->registerMetaTag(['name' => 'author', 'content' => Yii::$app->name]);
$this->registerMetaTag(['name' => 'keywords', 'content' => !empty($model->seo_keyword) ? $model->seo_keyword : Config::findOne(['key' => 'SEO_KEYWORD'])->value]);
$this->registerMetaTag(['name' => 'description', 'content' => !empty($model->seo_description) ? $model->seo_description : Config::findOne(['key' => 'SEO_DESCRIPTION'])->value]);

?>

<div class="row" role="article">
    <div class="col-md-12 main-container">
        <ul class="breadcrumb">
            <li><a href="<?= Yii::$app->homeUrl ?>" class="homepage-link" title="Quay lại trang chủ"><i class="glyphicon glyphicon-home"></i> Trang chủ</a></li>
            <li><span class="page-title"><?= $model->name ?></span></li>
        </ul>
        <div class="module-content page-detail">
            <h1><?= $model->name ?></h1>
            <div class="page-content rte table-responsive">
                <?= $model->content ?>
            </div>
        </div>
    </div>
</div>