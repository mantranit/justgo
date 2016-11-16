<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/activate-account', 
    'token' => $user->account_activation_token]);
?>

Chào <?= Html::encode($user->username) ?>,

Đây là đường dẫn để kích hoạt tài khoản của bạn trên website của chúng tôi:

<?= Html::a('Nhấp vào đây để kích hoạt tài khoản.', $resetLink) ?>
