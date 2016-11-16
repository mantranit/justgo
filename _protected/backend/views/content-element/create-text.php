<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;

/* @var $model common\models\ContentElement */

?>
<div class="pb-text" id="element<?= $model->id ?>">

    <div class="portlet-mini">
        <div class="portlet-mini-header">
            <h4 class="portlet-mini-title">Text</h4>
            <div class="portlet-mini-controls">
                <?= Html::a('', '#', [
                    'class' => 'open-modal edit-row fa fa-pencil-square-o',
                    'title' => 'Edit row',
                    'data' => [
                        'reveal-id' => 'modalEdit',
                        'id' => $model->id,
                        'url-get' => Url::toRoute(['content-element/view', 'id' => $model->id]),
                        'url-post' => Url::toRoute(['content-element/update', 'id' => $model->id])
                    ]
                ]) ?>
                <?= Html::a('', ['content-element/active', 'id' => $model->id], ['class' => $model->hide === 1 ? 'active-e-row fa fa-toggle-off' : 'active-e-row fa fa-toggle-on', 'title' => 'Show/Hide row']) ?>
                <?= Html::a('', ['content-element/delete', 'id' => $model->id], ['class' => 'delete-e-row fa fa-times', 'title' => 'Delete row', 'data' => ['method' => 'post']]) ?>
            </div>
        </div>
        <div class="portlet-mini-body">
            <form>
                <label> Title
                    <input type="text" name="title" value="" placeholder="<?= Yii::t('app', 'Enter title') ?>" />
                </label>
                <label> Type
                    <select name="type">
                        <option value="text">Text</option>
                        <option value="heading2">Heading 2</option>
                        <option value="heading3">Heading 3</option>
                        <option value="heading4">Heading 4</option>
                    </select>
                </label>
                <label> Text
                    <input type="text" name="text" value="" placeholder="<?= Yii::t('app', 'Enter text') ?>" />
                </label>
                <label> Extra class
                    <input type="text" name="extraClass" value="" placeholder="<?= Yii::t('app', 'Enter text') ?>" />
                </label>
                <label>
                    <button type="button" class="button round tiny"><?= Yii::t('app', 'Save') ?></button>
                </label>
            </form>
        </div>
    </div>
</div>
