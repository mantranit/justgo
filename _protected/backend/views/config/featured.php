<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 10/21/2015
 * Time: 5:18 PM
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use common\helpers\UtilHelper;
use backend\assets\ArrangementAsset;

/* @var $this yii\web\View */

$this->title = 'Sắp xếp sản phẩm nổi bật | ' . Yii::$app->name;

ArrangementAsset::register($this);

?>

<article class="site-index">
    <div class="portlet">
        <div class="portlet-title">
            <div class="caption">Sắp xếp sản phẩm nổi bật</div>
        </div>
        <div class="portlet-body">
            <div class="row">
            <div class="portlet-body feature-products">
                <div class="medium-6 columns related">
                    <div class="portlet small">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-check"></i>Sản phẩm nổi bật
                            </div>
                        </div>
                        <div class="portlet-body">
                            <ul class="connected list sortable grid" id="arrangementSelected">
                                <?php foreach ($products as $index => $item) {
                                    $img = UtilHelper::getPicture($item->image, 'thumb-list', true);
                                    ?>
                                    <li data-id="<?= $item->id ?>" title="<?= $item->name ?>">
                                        <img src="<?= $img ?>" alt="" />
                                        <a href="javascript:;"><?= $item->name ?></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>

                </div>
                <div class="medium-6 columns search">
                    <div class="portlet small">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-database"></i>Tất cả sản phẩm
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="search-box">
                                <input type="text" placeholder="Enter keyword" />
                            </div>
                            <ul class="connected list no2">
                                <?php foreach ($productSuggestion as $index => $item) {
                                    $img = UtilHelper::getPicture($item->image, 'thumb-list', true);
                                    ?>
                                    <li data-id="<?= $item->id ?>" title="<?= $item->name ?>">
                                        <img src="<?= $img ?>" alt="" />
                                        <a href="javascript:;"><?= $item->name ?></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <div class="action-buttons">
                        <?php $form = ActiveForm::begin([
                            'id' => 'arrangement-form'
                        ]); ?>
                        <input id="arrangementProduct" type="hidden" name="ArrangementProduct" value="" />
                        <?= Html::submitButton('Cập nhật', ['class' => 'small button radius']) ?>
                        <?= Html::a('Bỏ qua', ['index'], ['class' => 'small button secondary radius']) ?>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</article>


