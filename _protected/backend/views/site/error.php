<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = 'Không tìm thấy trang.';
?>
<div class="site-error">

    <p>
        <img src="<?= Yii::$app->view->theme->baseUrl ?>/images/404.jpg" alt="404" />
    </p>
    <p>
        <?= Html::a('Quay lại trang chủ', ['site/index']) ?>
    </p>
    <div style="display: none;">
        <h2><?= $name ?></h2>
        <h3><?= $message ?></h3>
    </div>
</div>
