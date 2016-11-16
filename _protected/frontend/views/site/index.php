<?php

use common\helpers\UtilHelper;
use common\models\Config;
use frontend\assets\SliderAsset;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider; */
/* @var $slide common\models\Content; */

SliderAsset::register($this);

$this->title = Config::findOne(['key' => 'SEO_TITLE'])->value;
$this->registerMetaTag(['name' => 'author', 'content' => Yii::$app->name]);
$this->registerMetaTag(['name' => 'keywords', 'content' => Config::findOne(['key' => 'SEO_KEYWORD'])->value]);
$this->registerMetaTag(['name' => 'description', 'content' => Config::findOne(['key' => 'SEO_DESCRIPTION'])->value]);

?>

<div class="row" role="presentation">
    <div class="col-md-12 banner">
        <div class="slide-container">
            <div class="slider single-item">
                <?php foreach ($dataProvider->getModels() as $index => $slide) { ?>
                <div class="item"<?= $index > 0 ? ' style="display:none" ' : '' ?>>
                    <img class="desktop" src="<?= $slide->summary ?>" title="<?= $slide->name ?>" alt="<?= $slide->name ?>" />
                    <img class="phone" src="<?= $slide->content ?>" title="<?= $slide->name ?>" alt="<?= $slide->name ?>" />
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="col-md-12 main-container">
        <div class="module-content">
            <header>
                <h2 class="title">SẢN PHẨM NỔI BẬT</h2>
            </header>
            <div class="content list">
                <?php foreach ($featured as $index => $product) { ?>
                    <?= $this->render('../product/_item', [
                        'index' => $index,
                        'product' => $product,
                    ]) ?>
                <?php } ?>
            </div>
        </div>
        <div class="module-content">
            <header>
                <h2 class="title">MÁY BỘ HP</h2>
            </header>
            <div class="content list">
                <?php foreach ($hpList as $index => $product) { ?>
                    <?= $this->render('../product/_item', [
                        'index' => $index,
                        'product' => $product,
                    ]) ?>
                <?php } ?>
            </div>
        </div>
        <div class="module-content">
            <header>
                <h2 class="title">MÁY BỘ DELL</h2>
            </header>
            <div class="content list">
                <?php foreach ($dellList as $index => $product) { ?>
                    <?= $this->render('../product/_item', [
                        'index' => $index,
                        'product' => $product,
                    ]) ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<?php
$this->registerJs("
    $('.single-item .item').show();
    $('.single-item').slick({
        dots: true,
        autoplay: true,
        arrows: false
    });
");
