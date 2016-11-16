<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý danh mục';
$this->params['breadcrumbs'][] = $this->title;
?>
<article class="category-index">
    <div class="portlet">
        <div class="portlet-title">
            <div class="caption"><?= Html::encode($this->title) ?></div>
            <div class="action">
                <ul class="button-group">
                    <li><?= Html::a('Thêm danh mục', ['create'], ['class' => 'tiny button round']) ?></li>
                </ul>
            </div>
        </div>
        <div class="portlet-body has-padding">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
            <?php Pjax::begin(['id' => 'categories']) ?>
            <table class="table table-striped table-bordered table-hover"><thead>
                <tr>
                    <th>#</th>
                    <th>Tên danh mục</th>
                    <th>Hiển thị</th>
                    <th>Kích hoạt</th>
                    <th>Sắp xếp</th>
                    <th>Menu</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($result as $index => $item) { ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td>
                            <?= Html::a($item['name'], ['update', 'id' => $item['id']]) ?>
                        </td>
                        <td>
                            <?= Html::a('', ['show-in-menu', 'id' => $item['id']],
                                ['class' => intval($item['show_in_menu']) === 1 ? 'fa fa-eye' : 'fa fa-eye-slash', 'title' => 'Show in menu',
                                    'data' =>[
                                        'confirm'=>"Are you sure you want to change state this category?",
                                        'method'=>"post"
                                    ]
                                ]) ?>
                        </td>
                        <td>
                            <?= Html::a('', ['active', 'id' => $item['id']],
                                ['class' => intval($item['activated']) === 1 ? 'fa fa-check' : 'fa fa-remove', 'title' => 'Active category',
                                    'data' => [
                                        'confirm' => "Are you sure you want to change state this category?",
                                        'method'=>"post"
                                    ]
                                ]) ?>
                        </td>
                        <td>
                            <?php if($index > 0) { ?>
                                <?= Html::a('', ['switch', 'id' => $item['id'], 'oid' => $result[$index-1]['id']],
                                    ['class' => 'fa fa-arrow-circle-up switch', 'title' => 'Up', 'data' => ['method' => "post"]]) ?>
                            <?php } else { ?>
                                <a class="fa fa-ban" style="visibility: hidden"></a>
                            <?php } ?>
                            <?php if($index < count($result)-1) { ?>
                                <?= Html::a('', ['switch', 'id' => $item['id'], 'oid' => $result[$index+1]['id']],
                                    ['class' => 'fa fa-arrow-circle-down switch', 'title' => 'Down', 'data' => ['method' => "post"]]) ?>
                            <?php } ?>
                        </td>
                        <td>
                            <?= Html::a('', ['update', 'id' => $item['id']],
                                ['class' => 'fa fa-pencil-square-o', 'title' => 'Manage category']) ?>
                            <?= Html::a('', ['delete', 'id' => $item['id']],
                                ['class' => 'fa fa-trash-o', 'title' => 'Delete category',
                                    'data' => [
                                        'confirm' => "Are you sure you want to delete this category?",
                                        'method' => "post"
                                    ]
                                ]) ?>
                        </td>
                    </tr>
                    <?php foreach($item['children'] as $inx => $child) { ?>
                        <tr data-key="5">
                            <td></td>
                            <td style="padding-left: 50px">
                                <?= Html::a($child->name, ['update', 'id' => $child->id]) ?>
                            </td>
                            <td style="padding-left: 50px">
                                <?= Html::a('', ['show-in-menu', 'id' => $child->id],
                                    [
                                        'class' => intval($child->show_in_menu) === 1 ? 'fa fa-eye' : 'fa fa-eye-slash',
                                        'title' => 'Show in menu',
                                        'data' => [
                                            'confirm' => "Are you sure you want to change state this category?",
                                            'method'=>"post"
                                        ]
                                    ]) ?>
                            </td>
                            <td style="padding-left: 50px">
                                <?= Html::a('', ['active', 'id' => $child->id],
                                    [
                                        'class' => $child->activated === 1 ? 'fa fa-check' : 'fa fa-remove',
                                        'title' => 'Active category',
                                        'data' => [
                                            'confirm' => "Are you sure you want to change state this category?",
                                            'method'=>"post"
                                        ]
                                    ]) ?>
                            </td>
                            <td style="padding-left: 50px">
                                <?php if($inx > 0) { ?>
                                    <?= Html::a('', ['switch', 'id' => $child->id, 'oid' => $item['children'][$inx-1]->id],
                                        ['class' => 'fa fa-arrow-circle-up switch', 'title' => 'Up', 'data' => ['method' => "post"]]) ?>
                                <?php } else { ?>
                                    <a class="fa fa-ban" style="visibility: hidden"></a>
                                <?php } ?>
                                <?php if($inx < count($item['children'])-1) { ?>
                                    <?= Html::a('', ['switch', 'id' => $child->id, 'oid' => $item['children'][$inx+1]->id],
                                        ['class' => 'fa fa-arrow-circle-down switch', 'title' => 'Down', 'data' => ['method' => "post"]]) ?>
                                <?php } ?>
                            </td>
                            <td style="padding-left: 50px">
                                <?= Html::a('', ['update', 'id' => $child->id],
                                    ['class' => 'fa fa-pencil-square-o', 'title' => 'Manage category']) ?>
                                <?= Html::a('', ['delete', 'id' => $child->id],
                                    ['class' => 'fa fa-trash-o', 'title' => 'Delete category',
                                        'data' => [
                                            'confirm'=>"Are you sure you want to delete this category?",
                                            'method'=>"post"
                                        ]
                                    ]) ?>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } ?>
                </tbody></table>
            <?php Pjax::end() ?>
        </div>
    </div>
</article>
<?php
$this->registerJs("
    $('#categories').on('click', '.switch', function(){
        var url = $(this).prop('href');
        $.post(url, function(){
            $.pjax.reload('#categories');
        });
        return false;
    });
");