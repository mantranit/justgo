<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Tag */

$this->title = 'Tạo tag mới';
$this->params['breadcrumbs'][] = ['label' => 'Danh sách tag', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<article class="tag-create">
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
        'model' => $model,
    ]) ?>

        </div>
    </div>
</article>
