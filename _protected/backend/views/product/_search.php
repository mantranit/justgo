<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Category;

/* @var $this yii\web\View */
/* @var $model common\models\ProductSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'name')->textInput(['placeholder' => 'Tên sản phẩm']) ?>

    <?php echo $form->field($model, 'price_init')->dropDownList(Category::getTreeView(), ['prompt' => '- Danh mục -']) ?>

    <?php echo $form->field($model, 'status')->dropDownList($model->getStatusList(), ['prompt' => '- Trạng thái -']) ?>

    <div class="form-group">
        <?= Html::submitButton('Tìm', ['class' => 'small round']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
