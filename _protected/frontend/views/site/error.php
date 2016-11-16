<?php
use yii\helpers\Html;
use common\models\Config;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = 'Không tìm thấy trang | ' . Config::findOne(['key' => 'SEO_TITLE'])->value;
$this->registerMetaTag(['name' => 'author', 'content' => Yii::$app->name]);
$this->registerMetaTag(['name' => 'keywords', 'content' => Config::findOne(['key' => 'SEO_KEYWORD'])->value]);
$this->registerMetaTag(['name' => 'description', 'content' => Config::findOne(['key' => 'SEO_DESCRIPTION'])->value]);

?>

<div class="row" role="article">
    <div class="col-md-12 main-container">
        <ul class="breadcrumb">
            <li><a href="<?= Yii::$app->homeUrl ?>" class="homepage-link" title="Quay lại trang chủ"><i class="glyphicon glyphicon-home"></i> Trang chủ</a></li>
            <li><span class="page-title">Lỗi</span></li>
        </ul>
        <div class="module-content page-detail">
            <h1><?= $message ?></h1>
            <div class="page-content rte">
                <div class="hidden">
                    <h2><?= $name ?></h2>
                    <h3><?= $message ?></h3>
                </div>
                <p>Không tìm thấy trang theo yêu cầu, bạn vui lòng kiểm tra lại đường dẫn.<br/>Cám ơn.</p>
            </div>
        </div>
    </div>
</div>