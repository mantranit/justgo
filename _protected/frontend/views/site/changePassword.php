<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 10/21/2015
 * Time: 11:27 AM
 */


use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Config;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ChangePasswordForm */

$this->title = 'Thay đổi mật khẩu | ' . Config::findOne(['key' => 'SEO_TITLE'])->value;
$this->registerMetaTag(['name' => 'author', 'content' => Yii::$app->name]);
$this->registerMetaTag(['name' => 'keywords', 'content' => Config::findOne(['key' => 'SEO_KEYWORD'])->value]);
$this->registerMetaTag(['name' => 'description', 'content' => Config::findOne(['key' => 'SEO_DESCRIPTION'])->value]);
?>

<div class="row" role="article">
    <div class="col-md-12 main-container">
        <ul class="breadcrumb">
            <li><a href="<?= Yii::$app->homeUrl ?>" class="homepage-link" title="Quay lại trang chủ"><i class="glyphicon glyphicon-home"></i> Trang chủ</a></li>
            <li><span class="page-title">Thay đổi mật khẩu</span></li>
        </ul>
        <div class="page-form-detail">
            <h1>Thay đổi mật khẩu</h1>
            <div class="page-content row">
                <div class="widget col-sm-6">
                    <header><h2>Vui lòng nhập mật khẩu</h2></header>
                    <div class="content-widget">
                        <?php $form = ActiveForm::begin(['id' => 'change-password-form']); ?>

                        <?= $form->field($model, 'password_old')->passwordInput() ?>
                        <?= $form->field($model, 'password')->passwordInput() ?>
                        <?= $form->field($model, 'password_confirm')->passwordInput() ?>

                        <div class="form-group">
                            <?= Html::submitButton('Thay đổi', ['class' => 'btn btn-primary']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
