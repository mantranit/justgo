<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 10/16/2015
 * Time: 1:27 PM
 */
?>

<?= \yii\widgets\Menu::widget([
    'items' => [
        ['label' => 'Trang chủ', 'url' => ['site/index']],
        ['label' => 'Giới thiệu', 'url' => ['page/view', 'slug' => 'gioi-thieu']],
        ['label' => 'Bảng giá', 'url' => ['page/view', 'slug' => 'bang-gia']],
        ['label' => 'Blog', 'url' => ['news/index']],
        ['label' => 'Hướng dẫn mua hàng', 'url' => ['page/view', 'slug' => 'huong-dan-mua-hang']],
        ['label' => 'Liên hệ', 'url' => ['site/contact']],
    ]
]) ?>
