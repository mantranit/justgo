<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use mihaildev\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $form yii\widgets\ActiveForm */

$this->registerJs("
    $('#category-name').on('blur', function(){
        var that = $(this),
            name = $(this).val();
        $.get(
            '" . Url::toRoute('category/checkingduplicated') . "',
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
    $('.field-category-slug').on('click', function(){
        $(this).children('input')
            .prop('disabled', false)
            .focus();
    });
");

?>

<div class="category-form row">

    <?php $form = ActiveForm::begin(); ?>
    <div class="large-12 columns">
        <ul class="tabs" data-tab role="tablist">
            <li class="tab-title active" role="presentational" >
                <a href="#panel2-1" role="tab" tabindex="0" aria-selected="true" controls="panel2-1">
                    Nội dung
                </a>
            </li>
            <li class="tab-title" role="presentational">
                <a href="#panel2-3" role="tab" tabindex="0" aria-selected="false" controls="panel2-3">
                    SEO
                </a>
            </li>
        </ul>
        <div class="tabs-content">
            <section role="tabpanel" aria-hidden="false" class="row content active" id="panel2-1">
                <div class="large-12 columns">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'parent_id')->dropDownList(ArrayHelper::map($model->getParents($model->id, 0, 0), 'id', 'name'), ['prompt'=>'- please select -']) ?>

                    <?= $form->field($model, 'description')->widget(CKEditor::className(), [
                        'editorOptions' => array_merge(Yii::$app->params['toolbarDescription'], [
                            'height' => 300
                        ]),
                    ]) ?>

                    <?= $form->field($model, 'general')->widget(CKEditor::className(), [
                        'editorOptions' => array_merge(Yii::$app->params['toolbarContent'], [
                            'height' => 500
                        ]),
                    ]) ?>
                </div>
            </section>
            <section role="tabpanel" aria-hidden="true" class="row content" id="panel2-3">
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

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Tạo mới' : 'Cập nhật', ['class' => 'small button radius']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
