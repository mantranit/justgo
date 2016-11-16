<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ContentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý bài viết';
$this->params['breadcrumbs'][] = $this->title;
?>
<article class="page-index">
    <div class="portlet">
        <div class="portlet-title">
            <div class="caption">Danh sách bài viết</div>
            <div class="action">
                <ul class="button-group">
                    <li><?= Html::a('Tạo mới', ['create'], ['class' => 'tiny button round', 'data' => ['reveal-id' => 'create']]) ?></li>
                </ul>
            </div>
        </div>
        <div class="portlet-body has-padding">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
            <?php Pjax::begin(['id' => 'news']) ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute'=>'name',
                        'format'=>'html',
                        'value'=> function($data) {
                            return Html::a($data->name, ['update', 'id' => $data->id]);
                        }
                    ],
                    [
                        'attribute' => 'status',
                        'filter' => $searchModel->getStatusList(),
                        'value' => function($data) {
                            return $data->statusName;
                        }
                    ],
                    // buttons
                    ['class' => 'yii\grid\ActionColumn',
                        'header' => "Menu",
                        'template' => '{update} {delete}',
                        'buttons' => [
                            'update' => function ($url, $model, $key) {
                                return Html::a('', $url, ['title'=>'Manage page',
                                    'class'=>'fa fa-pencil-square-o']);
                            },
                            'delete' => function ($url, $model, $key) {
                                return Html::a('', $url,
                                    ['title'=>'Delete page',
                                        'class'=>'fa fa-trash-o',
                                        'data' => [
                                            'confirm' => Yii::t('app', 'Are you sure you want to delete this page?'),
                                            'method' => 'post']
                                    ]);
                            }
                        ]
                    ], // ActionColumn
                ],
            ]); ?>
        </div>
    </div>
</article>
<?= $this->render('_popup') ?>
