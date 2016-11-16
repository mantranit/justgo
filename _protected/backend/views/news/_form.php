<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Content;
use yii\helpers\Url;
use backend\assets\PageBuilderAsset;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

/* @var $this yii\web\View */
/* @var $model common\models\Content */
/* @var $contentElement common\models\ContentElement */
/* @var $form yii\widgets\ActiveForm */

PageBuilderAsset::register($this);

$this->registerJs("
    $('#content-name').on('blur', function(){
        var that = $(this),
            name = $(this).val();
        $.get(
            '" . Url::toRoute('news/checkingduplicated') . "',
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
    $('.field-content-slug').on('click', function(){
        $(this).children('input')
            .prop('disabled', false)
            .focus();
    });
");

?>

<div class="page-form row">

    <?php $form = ActiveForm::begin([
        'id' => 'action-form'
    ]); ?>

    <div class="large-12 columns">
        <ul class="tabs" data-tab role="tablist">
            <li class="tab-title active" role="presentational" >
                <a href="#panel2-1" role="tab" tabindex="0" aria-selected="true" controls="panel2-1">
                    <?=Yii::t('app', 'Contents') ?>
                </a>
            </li>
            <li class="tab-title" role="presentational" >
                <a href="#panel2-2" role="tab" tabindex="0"aria-selected="false" controls="panel2-2">
                    <?=Yii::t('app', 'SEO') ?>
                </a>
            </li>
        </ul>
        <div class="tabs-content">
            <section role="tabpanel" aria-hidden="false" class="row content active" id="panel2-1">
                <div class="large-9 columns">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => 256]) ?>
                    <?= $form->field($model, 'summary')->textarea(['row' => 5]) ?>
                    <?= $form->field($model, 'content')->widget(CKEditor::className(), [
                        'editorOptions' => ElFinder::ckeditorOptions(['elfinder'],
                            array_merge(Yii::$app->params['toolbarContent'], [
                                'height' => 600
                            ])
                        ),
                    ]) ?>
                </div>
                <div class="large-3 columns">
                    <div class="form-group">
                        <label>Tags</label>
                        <textarea id="tags" rows="1" name="Tag" data-value='<?= Html::decode($tags) ?>' data-suggestions="<?= Html::decode($tagSuggestions) ?>"></textarea>
                    </div>
                    <div>
                        <hr>
                        <h6><?= Yii::t('app', 'Pictures') ?></h6>
                        <div id="filelist" class="view-thumbnail row">
                            <?php
                            foreach ($pictures as $index => $item) {
                                ?>
                                <div id="<?= $item->id ?>" class="photo-zone columns">
                                    <table cellpadding="0" cellspacing="0">
                                        <tr><td class="controls">
                                                <label><input type="radio" name="Content[image_id]" value="<?= $item->id ?>" <?php if(intval($item->id) === intval($model->image_id)) echo 'checked="checked"'; ?> /> <?= Yii::t('app', 'Main picture') ?></label>
                                                <a class="delete-image" data-id="<?= $item->id ?>" href="javascript:;"><i class="fa fa-trash-o"></i></a>
                                            </td></tr>
                                        <tr><td class="edit"><span class="name">
                                                <img src="<?= $item->show_url ?><?= $item->name ?>-thumb-upload.<?= $item->file_ext ?>" alt="<?= $item->name ?>" />
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
            </section>
            <section role="tabpanel" aria-hidden="true" class="row content" id="panel2-2">
                <div class="large-12 columns">
                    <?php if($model->slug !== null) { ?>
                        <?= $form->field($model, 'slug')->textInput(['maxlength' => 128, 'disabled' => 'disabled']) ?>
                    <?php } ?>
                    <?= $form->field($model, 'seo_title')->textarea(['maxlength' => 128, 'rows' => 2]) ?>
                    <?= $form->field($model, 'seo_keyword')->textarea(['maxlength' => 128, 'rows' => 2]) ?>
                    <?= $form->field($model, 'seo_description')->textarea(['maxlength' => 256, 'rows' => 5]) ?>
                </div>
            </section>
    </div>

    <div class="action-buttons">
        <input type="hidden" name="type-submit" value="" />
        <?= Html::submitButton($model->status === Content::STATUS_DRAFT ? 'Hiển thị' : 'Cập nhật',
            [
                'class' => 'small button radius',
                'data' => ['submit' => 1]
            ]) ?>
        <?php if($model->status === null || $model->status === Content::STATUS_DRAFT) { ?>
            <?= Html::submitButton($model->id ? 'Cập nhật tạm' : 'Lưu tạm',
                [
                    'class' => 'small button radius info',
                    'data' => ['submit' => 0]
                ]) ?>
        <?php } ?>
        <?= Html::a('Bỏ qua', ['index'], ['class' => 'small button secondary radius']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
