<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $role common\rbac\models\Role */

$this->title = 'Thêm mới người dùng';
$this->params['breadcrumbs'][] = ['label' => 'Danh sách người dùng', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<article class="user-create medium-6">
    <div class="portlet">
        <div class="portlet-title">
            <div class="caption"><?= Html::encode($this->title) ?></div>
            <div class="action">
                <ul class="button-group">
                    <li><?= Html::a('Quay lại', ['index'], ['class' => 'tiny button round secondary']) ?></li>
                </ul>
            </div>
        </div>
        <div class="portlet-body has-padding">

        <?= $this->render('_form', [
            'user' => $user,
            'role' => $role,
        ]) ?>

        </div>
    </div>
</article>
