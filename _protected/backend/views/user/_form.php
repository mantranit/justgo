<?php
use common\rbac\models\AuthItem;
use nenad\passwordStrength\PasswordInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $form yii\widgets\ActiveForm */
/* @var $role common\rbac\models\Role; */
?>
<div class="user-form">

    <?php $form = ActiveForm::begin(['id' => 'form-user']); ?>

        <?= $form->field($user, 'username') ?>

    <?= $form->field($user, 'full_name') ?>
    <?= $form->field($user, 'email') ?>

        <?php if ($user->scenario === 'create'): ?>
            <?= $form->field($user, 'password')->widget(PasswordInput::classname(), []) ?>
        <?php else: ?>
            <?= $form->field($user, 'password')->widget(PasswordInput::classname(), [])
                     ->passwordInput(['placeholder' => 'Nhập mật khẩu mới nếu muốn thay đổi'])
            ?>       
        <?php endif ?>

    <div class="large-12">

        <?= $form->field($user, 'status')->dropDownList($user->statusList) ?>

        <?php foreach (AuthItem::getRoles() as $item_name): ?>
            <?php $roles[$item_name->name] = $item_name->name ?>
        <?php endforeach ?>
        <?= $form->field($role, 'item_name')->dropDownList(['member' => 'member', 'admin' => 'admin']) ?>

    </div>

    <div class="form-group">     
        <?= Html::submitButton($user->isNewRecord ? 'Thêm mới'
            : 'Cập nhật', ['class' => $user->isNewRecord
            ? 'small button success radius' : 'small button radius']) ?>

        <?= Html::a('Bỏ qua', ['index'], ['class' => 'small button secondary radius']) ?>
    </div>

    <?php ActiveForm::end(); ?>
 
</div>
