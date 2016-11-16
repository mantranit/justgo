<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\assets\ProductAsset;
use yii\helpers\Url;
use common\models\Product;
use common\models\Category;
use yii\helpers\Json;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use common\helpers\UtilHelper;
use common\helpers\CurrencyHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $form yii\widgets\ActiveForm */

ProductAsset::register($this);

$this->registerJs("
    $('#product-name').on('blur', function(){
        var that = $(this),
            name = $(this).val();
        $.get(
            '" . Url::toRoute('product/checkingduplicated') . "',
            {'name': name" . ($model->id ? ", 'id': $model->id" : '') . "},
            function(data){
                if(data === true){
                    that.parent().removeClass('duplicated');
                } else {
                    that.parent().addClass('duplicated');
                }
            }
        );
    });
    $('.field-product-slug').on('click', function(){
        $(this).children('input')
            .prop('disabled', false)
            .focus();
    });
");

?>

<div class="product-form row">

    <?php $form = ActiveForm::begin([
        'id' => 'action-form'
    ]); ?>
    <div class="large-12 columns">
        <ul class="tabs" data-tab role="tablist">
            <li class="tab-title active" role="presentational" >
                <a href="#panel2-1" role="tab" tabindex="0" aria-selected="true" controls="panel2-1">
                    Thông tin sản phẩm
                </a>
            </li>
            <li class="tab-title" role="presentational" >
                <a href="#panel2-2" role="tab" tabindex="0" aria-selected="false" controls="panel2-2">
                    Nội dung
                </a>
            </li>
            <li class="tab-title" role="presentational">
                <a href="#panel2-3" role="tab" tabindex="0" aria-selected="false" controls="panel2-3">
                    SEO
                </a>
            </li>
            <li class="tab-title" role="presentational" >
                <a href="#panel2-4" role="tab" tabindex="0" aria-selected="false" controls="panel2-4">
                    Sản phẩm liên quan
                </a>
            </li>
        </ul>
        <div class="tabs-content">
            <section role="tabpanel" aria-hidden="false" class="row content active" id="panel2-1">
                <div class="large-9 columns">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => 256]) ?>
                    <hr/>
                    <div class="price-zone">
                        <?php foreach (Json::decode($model->price_string) as $index => $prices) { ?>
                            <div class="row">
                                <div class="small-4 columns">
                                    <strong>Giá bảo hành <?= strpos($index, '3') > 0 ? 3 : 12 ?> tháng</strong>
                                </div>
                                <?php foreach ($prices as $key => $value) { ?>
                                    <div class="small-4 columns">
                                        <div class="form-group">
                                            <label><span><?= Yii::t('app', $key) ?></span>
                                                <?php if($index === 'month3' && $key === 'current') { ?>
                                                    <?= Html::textInput('Price['.$index.']['.$key.']', (intval($value) !== 0 ? $value : CurrencyHelper::formatNumber($model->price)), ['class'=>'money-input']) ?>
                                                <?php } else { ?>
                                                    <?= Html::textInput('Price['.$index.']['.$key.']', $value, ['class'=>'money-input']) ?>
                                                <?php } ?>
                                            </label>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                    <hr/>
                    <?= $form->field($model, 'description')->widget(CKEditor::className(), [
                        'editorOptions' => array_merge(Yii::$app->params['toolbarIntro'], [
                            'height' => 300
                        ]),
                    ]) ?>

                    <div>
                        <hr>
                        <h6>Hình sản phẩm</h6>
                        <div id="filelist" class="view-thumbnail row">
                            <?php
                            foreach ($pictures as $index => $item) {
                                ?>
                                <div id="<?= $item->id ?>" class="photo-zone large-4 medium-6 columns">
                                    <table cellpadding="0" cellspacing="0">
                                        <tr><td class="controls">
                                                <label><input type="radio" name="Product[image_id]" value="<?= $item->id ?>" <?php if(intval($item->id) === intval($model->image_id)) echo 'checked="checked"'; ?> /> Hình chính</label>
                                                <a class="delete-image" data-id="<?= $item->id ?>" href="javascript:;"><i class="fa fa-trash-o"></i></a>
                                            </td></tr>
                                        <tr><td class="edit"><span class="name">
                                                    <a class="various" data-fancybox-type="iframe" href="<?= Url::toRoute(['file/watermask', 'id' => $item->id]) ?>">
                                                <img src="<?= $item->show_url ?><?= $item->name ?>-thumb-upload.<?= $item->file_ext ?>" alt="<?= $item->name ?>" />
                                                    </a>
                                            </span></td></tr>
                                        <tr><td class="caption">
                                                <textarea rows="4" name="Picture[<?= $item->id ?>][caption]" placeholder="Say something about this photo."><?= $item->caption ?></textarea>
                                                <input type="hidden" name="Picture[<?= $item->id ?>][id]" value="<?= $item->id ?>"/>
                                            </td></tr>
                                    </table></div>
                            <?php } ?>
                        </div>
                        <div id="uploader" data-upload-link="<?=Url::toRoute('image/create')?>">
                            <a id="pickfiles" href="javascript:;" class="tiny button radius">Select files</a>
                        </div>
                        <pre id="console"></pre>
                    </div>
                </div>
                <div class="large-3 columns">
                    <?php if($model->status !== Product::STATUS_DRAFT) { ?>
                        <?= $form->field($model, 'status')->dropDownList($model->getStatusListEdit()) ?>
                    <?php } ?>
                    <?= $form->field($model, 'is_hot')->checkbox() ?>
                    <?= $form->field($model, 'is_discount')->checkbox() ?>
                    <?= $form->field($model, 'discount')->textInput(['value' => CurrencyHelper::formatNumber($model->discount), 'class' => 'money-input']) ?>
                    <hr/>
                    <script>
                        var treeData = [
                            <?php
                            $tree = Category::getTree();
                            $total = count($tree);
                            $categoryList = Json::decode($categories);
                            $htmlString = '';
                            foreach ($tree as $index => $papa) {
                                $htmlString .= '{title: "'.$papa['name'].'", isFolder: true, key: "'.$papa['id'].'"';
                                if(in_array(intval($papa['id']), $categoryList)) {
                                    $htmlString .= ', select: true';
                                }

                                if(isset($papa['children'])) {
                                    $total2 = count($papa['children']);
                                    $htmlString .= ', children: [';
                                    foreach ($papa['children'] as $inx => $child) {
                                        $htmlString .= '{title: "'.$child['name'].'", isFolder: true, key: "'.$child['id'].'"';
                                        if(in_array(intval($child['id']), $categoryList)) {
                                            $htmlString .= ', select: true';
                                        }
                                        if($inx < $total2 - 1) {
                                            $htmlString .= '},';
                                        }
                                        else {
                                            $htmlString .= '}';
                                        }
                                    }
                                    $htmlString .= ']';
                                }

                                if($index < $total - 1) {
                                    $htmlString .= '},';
                                }
                                else {
                                    $htmlString .= '}';
                                }
                            }

                            echo $htmlString;
                            ?>
                        ];
                    </script>
                    <div class="form-group">
                        <label>Danh mục</label>
                        <div id="tree2"></div>
                        <input id="echoSelection2" type="hidden" name="Category" value="<?= implode(',', $categoryList) ?>"/>
                    </div>
                    <div class="form-group">
                        <label>Tags</label>
                        <textarea id="tags" rows="1" name="Tag" data-value='<?= Html::decode($tags) ?>' data-suggestions="<?= Html::decode($tagSuggestions) ?>"></textarea>
                    </div>
                </div>
            </section>
            <section role="tabpanel" aria-hidden="true" class="row content" id="panel2-2">
                <div class="large-12 columns">
                    <ul class="tabs" data-tab role="tablist">
                        <li class="tab-title active" role="presentational" >
                            <a href="#panel1-1" role="tab" tabindex="0" aria-selected="true" controls="panel1-1">
                                Tổng quan
                            </a>
                        </li>
                        <li class="tab-title" role="presentational" >
                            <a href="#panel1-2" role="tab" tabindex="0"aria-selected="false" controls="panel1-2">
                                Thông số kỷ thuật
                            </a>
                        </li>
                    </ul>
                    <div class="tabs-content">
                        <section role="tabpanel" aria-hidden="false" class="row content active" id="panel1-1">
                            <div class="large-12 columns">
                                <?= $form->field($model, 'general')->widget(CKEditor::className(), [
                                    'editorOptions' => ElFinder::ckeditorOptions(['elfinder'],
                                        array_merge(Yii::$app->params['toolbarContent'], [
                                            'height' => 600
                                        ])
                                    ),
                                ]) ?>
                            </div>
                        </section>
                        <section role="tabpanel" aria-hidden="true" class="row content" id="panel1-2">
                            <div class="large-12 columns">
                                <?= $form->field($model, 'info_tech')->widget(CKEditor::className(), [
                                    'editorOptions' => array_merge(Yii::$app->params['toolbarIntro'], [
                                        'height' => 600
                                    ]),
                                ]) ?>
                            </div>
                        </section>
                    </div>

                </div>
            </section>
            <section role="tabpanel" aria-hidden="true" class="row content" id="panel2-3">
                <div class="columns">
                    <?php if($model->slug !== null) { ?>
                        <?= $form->field($model, 'slug')->textInput(['maxlength' => 128, 'disabled' => 'disabled']) ?>
                    <?php } ?>
                    <?= $form->field($model, 'seo_title')->textarea(['maxlength' => 128, 'rows' => 2]) ?>
                    <?= $form->field($model, 'seo_keyword')->textarea(['maxlength' => 128, 'rows' => 2]) ?>
                    <?= $form->field($model, 'seo_description')->textarea(['maxlength' => 256, 'rows' => 5]) ?>
                </div>
            </section>
            <section role="tabpanel" aria-hidden="true" class="row content" id="panel2-4">
                <input id="relatedProduct" type="hidden" name="Related" value="" />
                <div class="medium-6 columns related">
                    <div class="portlet small">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-cogs"></i>Sản phẩm liên quan
                            </div>
                        </div>
                        <div class="portlet-body">
                            <ul class="connected list sortable grid">
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
                                <i class="fa fa-cogs"></i>Tất cả sản phẩm
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
                </div>
            </section>

            <div class="action-buttons">
                <input type="hidden" name="type-submit" value="" />
                <?= Html::submitButton($model->status === Product::STATUS_DRAFT ? 'Hiển thị' : 'Cập nhật',
                    [
                        'class' => 'small button radius',
                        'data' => ['submit' => 1]
                    ]) ?>
                <?php if($model->status === null || $model->status === Product::STATUS_DRAFT) { ?>
                    <?= Html::submitButton($model->id ? 'Cập nhật tạm' : 'Lưu tạm',
                        [
                            'class' => 'small button radius info',
                            'data' => ['submit' => 0]
                        ]) ?>
                <?php } ?>
                <?= Html::a('Bỏ qua', ['index'], ['class' => 'small button secondary radius']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
