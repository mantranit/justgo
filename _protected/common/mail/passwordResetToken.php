<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 
    'token' => $user->password_reset_token]);
?>

Chào <?= Html::encode($user->username) ?>,

Đây là đường dẫn để đặt lại mật khẩu của bạn trên website của chúng tôi:

<?= Html::a('Nhấp vào đây để đặt lại mật khẩu.', $resetLink) ?>
