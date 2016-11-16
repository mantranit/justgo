<?php
/**
 * Created by PhpStorm.
 * User: tdmman
 * Date: 4/29/2015
 * Time: 10:05 AM
 */

use yii\widgets\LinkPager;
use frontend\assets\SearchAsset;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use \common\models\Config;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider; */

SearchAsset::register($this);

$this->title = Config::findOne(['key' => 'SEO_TITLE'])->value;
$this->registerMetaTag(['name' => 'author', 'content' => Yii::$app->name]);
$this->registerMetaTag(['name' => 'keywords', 'content' => Config::findOne(['key' => 'SEO_KEYWORD'])->value]);
$this->registerMetaTag(['name' => 'description', 'content' => Config::findOne(['key' => 'SEO_DESCRIPTION'])->value]);

?>
    <div class="row" role="article">
        <div class="col-md-12 main-container">
            <ul class="breadcrumb">
                <li><a href="<?= Yii::$app->homeUrl ?>" class="homepage-link" title="Quay lại trang chủ"><i class="glyphicon glyphicon-home"></i> Trang chủ</a></li>
                <li><span class="page-title">Tìm kiếm</span></li>
            </ul>
            <div class="module-content category-detail">
                <h1>Kết quả tìm kiếm cho: <?= Yii::$app->request->get('term') ?></h1>
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
                                    <option value="<?= Url::toRoute(['site/search', 'term' => Yii::$app->request->get('term')]) ?>">Giá giảm</option>
                                    <option <?= $orderBy === 'gt' ? 'selected="selected"' : '' ?> value="<?= Url::toRoute(['site/search', 'term' => Yii::$app->request->get('term'), 'orderby' => 'gt']) ?>">Giá tăng</option>
                                    <option <?= $orderBy === 'az' ? 'selected="selected"' : '' ?> value="<?= Url::toRoute(['site/search', 'term' => Yii::$app->request->get('term'), 'orderby' => 'az']) ?>">Tên A - Z</option>
                                    <option <?= $orderBy === 'za' ? 'selected="selected"' : '' ?> value="<?= Url::toRoute(['site/search', 'term' => Yii::$app->request->get('term'), 'orderby' => 'za']) ?>">Tên Z - A</option>
                                </select>
                            </div>
                        <?php } ?>
                    </header>
                    <div class="content-widget list">
                        <?php foreach ($dataProvider->getModels() as $index => $product) { ?>
                            <?= $this->render('../product/_item', [
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