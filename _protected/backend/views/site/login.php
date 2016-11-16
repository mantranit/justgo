<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Đăng nhập | ' . Yii::$app->name;
?>
    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
    <h3 class="form-title">Đăng nhập tài khoản</h3>
    <?php //-- use email or username field depending on model scenario --// ?>

    <?php if (false): ?>
        <?= $form->field($model, 'email', ['template' => "{label}<div class='input-icon'><i class='fa fa-envelope'></i>{input}</div>{error}"])
            ->input('email', ['placeholder' => 'Email', 'autocomplete'=>'off'])
            ->label('Email', ['class'=>'control-label']) ?>
    <?php else: ?>
        <?= $form->field($model, 'username', ['template' => "{label}<div class='input-icon'><i class='fa fa-user'></i>{input}</div>{error}"])
            ->textInput(['placeholder' => 'Tên đăng nhập', 'autocomplete'=>'off'])
            ->label('Tên đăng nhập', ['class'=>'control-label']) ?>
    <?php endif ?>

    <?= $form->field($model, 'password', ['template' => "{label}<div class='input-icon'><i class='fa fa-lock'></i>{input}</div>{error}"])
        ->passwordInput(['placeholder' => 'Mật khẩu', 'autocomplete'=>'off'])
        ->label('Mật khẩu', ['class'=>'control-label']) ?>

    <div class="form-actions clearfix">
        <?= $form->field($model, 'rememberMe')->checkbox(['template' => "<label class='checkbox'>{input}{label}</label>"]) ?>
        <?= Html::submitButton('Đăng nhập <i class="fa fa-sign-in"></i>', ['class' => 'btn green-haze pull-right', 'name' => 'login-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

