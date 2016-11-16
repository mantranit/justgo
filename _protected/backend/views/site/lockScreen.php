<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Locked screen');
?>

    <h3 class="form-title"><?= $this->title ?></h3>
    <?php $form = ActiveForm::begin([
        'id' => 'locked-form',
        'action' => ['site/login', 'previous' => $previous]
    ]);
?>
    <h5><i class="fa fa-user"></i><?= $model->username ?></h5>
    <?= $form->field($model, 'username')->hiddenInput() ?>
    <?= $form->field($model, 'password', ['template' => "{label}<div class='input-icon'><i class='fa fa-lock'></i>{input}</div>{error}"])
        ->passwordInput(['placeholder' => 'Mật khẩu', 'autocomplete'=>'off'])
        ->label('Mật khẩu', ['class'=>'control-label']) ?>

    <div class="form-actions clearfix">
        <?= Html::a('Bạn không phải là: ' . $model->username . '?', ['site/login']) ?>
        <?= Html::submitButton('Đăng nhập <i class="fa fa-sign-in"></i>', ['class' => 'btn green-haze pull-right', 'name' => 'login-button']) ?>
    </div>
    <?php ActiveForm::end(); ?>