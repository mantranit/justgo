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
            '" . Url::toRoute('page/checkingduplicated') . "',
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
                <div class="large-12 columns">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => 256]) ?>

                    <?= $form->field($model, 'using_page_builder')->radioList([0 => Yii::t('app', 'Normal Editor'), 1 => Yii::t('app', 'Page Builder')]) ?>

                    <aside class="normal-editor radio-group radio-item-0" <?= intval($model->using_page_builder) === 1 ? 'style="display: none"' : '' ?> >

                        <?= $form->field($model, 'content')->widget(CKEditor::className(), [
                            'editorOptions' => ElFinder::ckeditorOptions(['elfinder'],
                                array_merge(Yii::$app->params['toolbarContent'], [
                                    'height' => 600
                                ])
                            ),
                        ]) ?>
                    </aside>
                    <aside class="page-builder-editor radio-group radio-item-1" <?= intval($model->using_page_builder) === 0 ? 'style="display: none"' : '' ?> >
                        <br/>
                        <div class="page-builder" data-href="<?= Url::toRoute(['content-element/index', 'contentId' => $model->id]) ?>">
                            <div class="controls">
                                <?= Html::a('', ['content-element/create', 'contentId' => $model->id, 'type' => 'row'], ['class' => 'add-e-pb fa fa-plus', 'title' => 'Add new row']) ?>
                            </div>
                        </div>
                        <br/>
                    </aside>
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
