<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\File */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="file-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 128]) ?>

    <?= $form->field($model, 'caption')->textInput(['maxlength' => 1024]) ?>

    <?= $form->field($model, 'show_url')->textInput(['maxlength' => 128]) ?>

    <?= $form->field($model, 'directory')->textInput(['maxlength' => 128]) ?>

    <?= $form->field($model, 'dimension')->textInput(['maxlength' => 16]) ?>

    <?= $form->field($model, 'width')->textInput() ?>

    <?= $form->field($model, 'height')->textInput() ?>

    <?= $form->field($model, 'file_name')->textInput(['maxlength' => 64]) ?>

    <?= $form->field($model, 'file_type')->textInput(['maxlength' => 16]) ?>

    <?= $form->field($model, 'file_size')->textInput(['maxlength' => 16]) ?>

    <?= $form->field($model, 'file_ext')->textInput(['maxlength' => 8]) ?>

    <?= $form->field($model, 'deleted')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
