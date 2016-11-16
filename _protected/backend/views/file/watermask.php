<?php
/**
 * Created by PhpStorm.
 * User: ManTran
 * Date: 7/17/2015
 * Time: 4:14 PM
 */

use backend\assets\WatermaskAsset;
use yii\helpers\Html;
use mihaildev\elfinder\InputFile;

/* @var $this yii\web\View */
/* @var $model common\models\File */

$this->title = Yii::t('app', 'Edit Image');

WatermaskAsset::register($this);

?>
<article class="category-index">
    <div class="portlet">
        <div class="portlet-title">
            <div class="caption"><?= Html::encode($this->title) ?></div>
        </div>
        <div class="portlet-body has-padding">
            <div class="watermask-controls">
                <div style="display: none">
                    <?= InputFile::widget([
                        'path' => 'image',
                        'filter'     => 'image',
                        'name'       => 'myinput',
                    ]); ?>
                </div>
                <ul class="button-group">
                    <li>
                        <?= Html::a(Yii::t('app', 'Add image'), 'javascript:;', ['id' => 'add-watermask-button', 'class' => 'button small round']); ?>
                    </li>
                    <li>
                        <?= Html::a(Yii::t('app', 'Text'), 'javascript:;', ['id' => 'add-text-button', 'class' => 'button small round']); ?>
                    </li>
                    <li>
                        <?= Html::a(Yii::t('app', 'Delete'), 'javascript:;', ['id' => 'delete-watermask-button', 'disabled' => 'disabled', 'class' => 'button small disabled round']); ?>
                    </li>
                </ul>
                <div id="color-opacity-controls">
                    <div>
                        <label for="opacity">Opacity: </label>
                        <input type="range" value="100"/>
                    </div>
                    <div>
                        <label for="color">Color: </label>
                        <input type="color" style="width:40px"/>
                    </div>
                </div>
            </div>

            <canvas id="canvas" width="<?= $model->width ?>" height="<?= $model->height ?>" data-background="<?= ($model->show_url . $model->file_name . '-origin.' . $model->file_ext) ?>"></canvas>
            <div class="button-group-bottom">
                <button type="button" class="small radius" id="watermask-save" data-submit="<?= \yii\helpers\Url::toRoute(['file/watermask-save', 'id' => $model->id]) ?>"><?= Yii::t('app', 'Save') ?></button>
                <a href="javascript:parent.jQuery.fancybox.close();" class="button small secondary radius"><?= Yii::t('app', 'Cancel') ?></a>
            </div>
        </div>
    </div>
</article>
