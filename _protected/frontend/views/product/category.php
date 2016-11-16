<?php
/**
 * Created by PhpStorm.
 * User: ManTran
 * Date: 6/29/2015
 * Time: 11:07 AM
 */

use yii\helpers\Url;
use common\models\Config;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $product common\models\Product */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = !empty($model->seo_title) ? $model->seo_title : $model->name . ' | ' . Config::findOne(['key' => 'SEO_TITLE'])->value;
$this->registerMetaTag(['name' => 'author', 'content' => Yii::$app->name]);
$this->registerMetaTag(['name' => 'keywords', 'content' => !empty($model->seo_keyword) ? $model->seo_keyword : Config::findOne(['key' => 'SEO_KEYWORD'])->value]);
$this->registerMetaTag(['name' => 'description', 'content' => !empty($model->seo_description) ? $model->seo_description : Config::findOne(['key' => 'SEO_DESCRIPTION'])->value]);

?>
<div class="row" role="article">
    <div class="col-md-12 main-container">
        <ul class="breadcrumb">
            <li><a href="<?= Yii::$app->homeUrl ?>" class="homepage-link" title="Quay lại trang chủ"><i class="glyphicon glyphicon-home"></i> Trang chủ</a></li>
            <?php if($model->parent_id > 0) { ?>
                <li><a href="<?= Url::toRoute(['product/category', 'id' => $model->parent_id, 'slug' => $model->parent->slug]) ?>" title="<?= $model->parent->name ?>"><?= $model->parent->name ?></a></li>
            <?php } ?>
            <li><span class="page-title"><?= $model->name ?></span></li>
        </ul>
        <div class="module-content category-detail">
            <h1><?= $model->name ?></h1>
            <div class="category-description rte">
                <?= $model->description ?>
            </div>
            <?php Pjax::begin(['id' => 'products']) ?>
            <div class="widget">
                <header>
                    <?php if($dataProvider->totalCount === 0) { ?>
                        <div class="total-count">Không có sản phẩm</div>
                    <?php } else { ?>
                        <div class="total-count">Tổng cộng có <?= $dataProvider->totalCount ?> sản phẩm</div>
                        <div class="dropdownbox">
                            <span>Sắp xếp</span>
                            <?php $orderBy = Yii::$app->getRequest()->getQueryParam('orderby'); ?>
                            <select>
                                <option value="<?= Url::toRoute(['product/category', 'id' => $model->id, 'slug' => $model->slug]) ?>">Giá giảm</option>
                                <option <?= $orderBy === 'gt' ? 'selected="selected"' : '' ?> value="<?= Url::toRoute(['product/category', 'id' => $model->id, 'slug' => $model->slug, 'orderby' => 'gt']) ?>">Giá tăng</option>
                                <option <?= $orderBy === 'az' ? 'selected="selected"' : '' ?> value="<?= Url::toRoute(['product/category', 'id' => $model->id, 'slug' => $model->slug, 'orderby' => 'az']) ?>">Tên A - Z</option>
                                <option <?= $orderBy === 'za' ? 'selected="selected"' : '' ?> value="<?= Url::toRoute(['product/category', 'id' => $model->id, 'slug' => $model->slug, 'orderby' => 'za']) ?>">Tên Z - A</option>
                            </select>
                        </div>
                    <?php } ?>
                </header>
                <div class="content-widget list">
                    <?php foreach ($dataProvider->getModels() as $index => $product) { ?>
                        <?= $this->render('_item', [
                            'index' => $index,
                            'product' => $product,
                        ]) ?>
                    <?php } ?>
                    <div class="clearfix"></div>
                    <nav class="pagination-bottom">
                        <?= LinkPager::widget([
                            'pagination'=>$dataProvider->pagination,
                            'nextPageLabel' => 'Trang kế tiếp &raquo;',
                            'prevPageLabel' => '&laquo; Quay lại',
                        ]) ?>
                    </nav>
                </div>
            </div>
            <?php Pjax::end() ?>
        </div>
    </div>
</div>
<?php
$this->registerJs("
    $('#products').on('change', '.dropdownbox select', function(){
        var url = $(this).val();
        window.location.href = url;
    });
");