<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\helpers\UtilHelper;
use yii\widgets\Pjax;
use common\models\Category;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý sản phẩm';
$this->params['breadcrumbs'][] = $this->title;
?>
<article class="product-index">
    <div class="portlet">
        <div class="portlet-title">
            <div class="caption">Danh sách sản phẩm</div>
            <div class="action">
                <ul class="button-group">
                    <li><?= Html::a('Thêm sản phẩm', ['create'], ['class' => 'tiny button round', 'data' => ['reveal-id' => 'create']]) ?></li>
                </ul>
            </div>
        </div>
        <div class="portlet-body has-padding">
            <?php echo $this->render('_search', ['model' => $searchModel]); ?>
            <?php Pjax::begin(['id' => 'products']) ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                //'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => '#',
                        'format' => 'html',
                        'value' => function($data) {
                            $img = UtilHelper::getPicture($data->image, 'thumb-list', true);
                            return Html::a(Html::img($img, ['width'=>'100']), ['update', 'id' => $data->id]);
                        }
                    ],
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
                    [
                        'header' => 'Hiển thị',
                        'format' => 'raw',
                        'value' => function($data) {
                            return Html::a('', ['active', 'id' => $data->id],
                                [
                                    'class' => intval($data->activated) === 1 ? 'active fa fa-eye' : 'active fa fa-eye-slash',
                                    'title' => 'Show in menu',
                                    'data' => [
                                        'confirm' => "Are you sure you want to change state this category?",
                                        'method'=>"post"
                                    ]
                                ]);
                        }
                    ],
                    // buttons
                    ['class' => 'yii\grid\ActionColumn',
                        'header' => "Menu",
                        'template' => '{update} {delete}',
                        'buttons' => [
                            'update' => function ($url, $model, $key) {
                                return Html::a('', $url, ['title'=>'Manage product',
                                    'class'=>'fa fa-pencil-square-o']);
                            },
                            'delete' => function ($url, $model, $key) {
                                return Html::a('', $url,
                                    ['title'=>'Delete product',
                                        'class'=>'fa fa-trash-o',
                                        'data' => [
                                            'confirm' => Yii::t('app', 'Are you sure you want to delete this product?'),
                                            'method' => 'post']
                                    ]);
                            }
                        ]
                    ], // ActionColumn
                ],
            ]); ?>
            <?php Pjax::end() ?>

        </div>
    </div>
</article>

<?php
$this->registerJs("
$('#products').on('click', '.active', function(e){
    var url = $(this).attr('href') + '?ajax=1';
    $.post(url, function(){
        $.pjax.reload({container: '#products'});
    });
    return false;
});
");
?>

<?= $this->render('_popup') ?>