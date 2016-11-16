<?php

use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ContentElementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<?php foreach ($rows as $irow => $model) { ?>

    <div class="pb-row" id="element<?= $model->id ?>">
        <?php foreach (Json::decode(Json::decode($model->content)['columnsType']) as $index => $value) { ?>
            <div class="pb-column pb-col" style="width: <?= ($value/array_sum(Json::decode(Json::decode($model->content)['columnsType']))) * 100 ?>%">
                <div class="pb-column-content" id="column-content-<?= $model->id . ($index + 1) ?>">

                    <div class="controls">
                        <?= Html::a('', '#', [
                            'class' => 'open-modal fa fa-th-list',
                            'title' => 'Edit columns',
                            'data' => [
                                'reveal-id' => 'modalColumn',
                                'id' => $model->id,
                                'url-get' => Url::toRoute(['content-element/view', 'id' => $model->id]),
                                'url-post' => Url::toRoute(['content-element/update', 'id' => $model->id])
                            ]
                        ]) ?>
                        <?= Html::a('', '#', [
                            'class' => 'open-modal add-element fa fa-plus',
                            'title' => 'Add new element',
                            'data' => [
                                'reveal-id' => 'modalAddElement',
                                'id' => $model->id,
                                'item-id' => $model->id . ($index + 1),
                                'url-post' => Url::toRoute(['content-element/create', 'contentId' => $model->content_id])
                            ]
                        ]) ?>
                    </div>
                </div>
            </div>
        <?php } ?>

        <div class="controls">
            <?= Html::a('', '#', [
                'class' => 'open-modal edit-row fa fa-pencil-square-o',
                'title' => 'Edit row',
                'data' => [
                    'reveal-id' => 'modalEditRow',
                    'id' => $model->id,
                    'url-get' => Url::toRoute(['content-element/view', 'id' => $model->id]),
                    'url-post' => Url::toRoute(['content-element/update', 'id' => $model->id])
                ]
            ]) ?>
            <?= Html::a('', ['content-element/active', 'id' => $model->id], ['class' => $model->hide === 1 ? 'active-e-row fa fa-toggle-off' : 'active-e-row fa fa-toggle-on', 'title' => 'Show/Hide row']) ?>
            <?= Html::a('', ['content-element/delete', 'id' => $model->id], ['class' => 'delete-e-row fa fa-times', 'title' => 'Delete row', 'data' => ['method' => 'post']]) ?>
        </div>
    </div>

<?php } ?>

<div id="modalEditRow" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
    <h3 id="modalTitle">Edit row</h3>
    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
    <form>
        <div class="row">
            <div class="columns">
                <label>Container
                    <select name="container">
                        <option value="full">Full width</option>
                        <option value="fix">Fix width</option>
                    </select>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="columns">
                <label>Column
                    <select name="columnsType">
                        <option value="[1]">1/1</option>
                        <option value="[1,1]">1/2 - 1/2</option>
                        <option value="[1,2]">1/3 - 2/3</option>
                        <option value="[1,1,1]">1/3 - 1/3 - 1/3</option>
                        <option value="[2,1]">2/3 - 1/3</option>
                        <option value="[1,3]">1/4 - 3/4</option>
                        <option value="[1,2,1]">1/4 - 2/4 - 1/4</option>
                        <option value="[1,1,2]">1/4 - 1/4 - 2/4</option>
                        <option value="[2,1,1]">2/4 - 1/4 - 1/4</option>
                        <option value="[3,1]">3/4 - 1/4</option>
                        <option value="[1,1,1,1]">1/4 - 1/4 - 1/4 - 1/4</option>
                    </select>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="columns">
                <label>Extra classes
                    <input type="text" name="extraClass" placeholder="Extra classes" />
                </label>
            </div>
        </div>
        <div class="row modal-button-group">
            <a class="save pb-row-btn button small radius" data-modal-id="modalEditRow"><?= Yii::t('app', 'Save') ?></a>
            <a class="cancel button small radius secondary" data-modal-id="modalEditRow"><?= Yii::t('app', 'Cancel') ?></a>
        </div>
    </form>
</div>

<div id="modalColumn" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
    <h3 id="modalTitle">Edit row</h3>
    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
    <form>
        <div class="row">
            <div class="columns">
                <label>Extra classes
                    <input type="text" name="extraClass" placeholder="Extra classes" />
                </label>
            </div>
        </div>
        <div class="row modal-button-group">
            <a class="save button small radius" data-modal-id="modalColumn"><?= Yii::t('app', 'Save') ?></a>
            <a class="cancel button small radius secondary" data-modal-id="modalColumn"><?= Yii::t('app', 'Cancel') ?></a>
        </div>
    </form>
</div>

<div id="modalAddElement" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
    <h3 id="modalTitle">Add new element</h3>
    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
    <form>
        <input type="hidden" name="parent_id" value="" />
        <div class="row">
            <div class="columns">
                <label>Column
                    <select name="type">
                        <option value="text">Text</option>
                        <option value="image">Image</option>
                        <option value="textarea">Textarea</option>
                    </select>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="columns">
                <label>Extra classes
                    <input type="text" name="extraClass" placeholder="Extra classes" />
                </label>
            </div>
        </div>
        <div class="row modal-button-group">
            <a class="save pb-element-btn button small radius" data-modal-id="modalAddElement"><?= Yii::t('app', 'Save') ?></a>
            <a class="cancel button small radius secondary" data-modal-id="modalAddElement"><?= Yii::t('app', 'Cancel') ?></a>
        </div>
    </form>
</div>