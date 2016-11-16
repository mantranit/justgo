<?php
/**
 * Created by PhpStorm.
 * User: ManTran
 * Date: 7/1/2015
 * Time: 3:16 PM
 */

use yii\helpers\Html;
use yii\helpers\Url;
use common\helpers\UtilHelper;
use yii\widgets\LinkPager;
use common\models\Config;
use common\models\File;
use common\models\Tag;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $news common\models\Content */

$this->title = 'Blog | ' . Config::findOne(['key' => 'SEO_TITLE'])->value;
$this->registerMetaTag(['name' => 'author', 'content' => Yii::$app->name]);
$this->registerMetaTag(['name' => 'keywords', 'content' => Config::findOne(['key' => 'SEO_KEYWORD'])->value]);
$this->registerMetaTag(['name' => 'description', 'content' => Config::findOne(['key' => 'SEO_DESCRIPTION'])->value]);

?>

<div class="row" role="article">
    <div class="col-md-12 main-container">
        <ul class="breadcrumb">
            <li><a href="<?= Yii::$app->homeUrl ?>" class="homepage-link" title="Quay lại trang chủ"><i class="glyphicon glyphicon-home"></i> Trang chủ</a></li>
            <li><span class="page-title">Blog</span></li>
        </ul>
        <div class="module-content category-detail">
            <h1>Blog</h1>
            <?php Pjax::begin(['id' => 'blog']) ?>
            <div class="widget">
                <div class="news-style-list">
                    <?php foreach ($dataProvider->getModels() as $index => $news) { ?>
                        <article>
                            <h2><?= Html::a($news->name, ['news/view', 'slug' => $news->slug]) ?></h2>
                            <div class="meta-info">
                                <div class="blog-article_date">
                                    <span>Đăng ngày: </span>
                                    <time pubdate datetime="<?= date('Y-m-d', $news->published_date) ?>">
                                        <span class="day"><?= date('d/m/Y', $news->published_date) ?></span>
                                    </time>
                                </div>
                                <?php
                                $tags = Tag::find()
                                    ->innerJoin('tbl_content_tag', 'tbl_content_tag.tag_id = tbl_tag.id')
                                    ->where(['tbl_tag.deleted' => 0, 'tbl_content_tag.deleted' => 0, 'tbl_content_tag.content_id' => $news->id])
                                    ->all();
                                if(count($tags) > 0) {
                                ?>
                                <div class="blog-article_meta-tags">
                                    <span>Tags: </span>
                                    <?php
                                    }
                                    foreach ($tags as $index => $tag) {
                                        if($index > 0)
                                            echo ', ';
                                        echo Html::a($tag->name, ['news/tag', 'slug' => $tag->slug]);
                                    }
                                    if(count($tags) > 0) { ?>
                                </div>
                            <?php } ?>
                            </div>
                            <div class="news-image-list">
                                <a href="<?= Url::toRoute(['news/view', 'slug' => $news->slug]) ?>">
                                    <?php
                                    $images = File::find()
                                        ->innerJoin('tbl_content_file', 'tbl_content_file.file_id = tbl_file.id')
                                        ->where(['tbl_file.deleted' => 0, 'tbl_content_file.deleted' => 0, 'tbl_content_file.content_id' => $news->id])
                                        ->all();
                                    foreach ($images as $img) {
                                        echo UtilHelper::getPicture($img, 'thumbnail-slide');
                                    }
                                    ?>
                                </a>
                            </div>
                            <?= $news->summary ?>
                            <nobr><?= Html::a('Chi tiết <i class="glyphicon glyphicon-arrow-right"></i>', ['news/view', 'slug' => $news->slug], ['class' => 'read-more']) ?></nobr>
                        </article>
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