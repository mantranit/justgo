<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Content */

$this->title = 'Cập nhật banner';
$this->params['breadcrumbs'][] = ['label' => 'Danh sách banner', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<article class="page-update">

    <div class="portlet">
        <div class="portlet-title">
            <div class="caption"><?= Html::encode($this->title) ?></div>
            <div class="action">
                <ul class="button-group">
                    <li><?= Html::a('Quay lại', ['index'], ['class' => 'tiny button round secondary']) ?></li>
                    <li><?= Html::a('Thêm mới', ['create'], ['class' => 'tiny button round secondary', 'data' => ['reveal-id' => 'create']]) ?></li>
                </ul>
            </div>
        </div>
        <div class="portlet-body">

            <?= $this->render('_form', [
                'model' => $model,
                'pictures' => $pictures,
            ]) ?>

        </div>
    </div>
</article>
<?= $this->render('_popup') ?>