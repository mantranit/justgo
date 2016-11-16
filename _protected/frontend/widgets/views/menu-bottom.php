<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 10/16/2015
 * Time: 1:32 PM
 */

use yii\helpers\Html;

?>

<nav class="nav-footer row" role="navigation">
    <div class="col-sm-4">
        <ul class="mainmenu">
            <li class="has-submenu">
                <?= Html::a('Trang chủ', ['site/index']) ?>
                <?= \yii\widgets\Menu::widget([
                    'items' => [
                        ['label' => 'Giới thiệu', 'url' => ['page/view', 'slug' => 'gioi-thieu']],
                        ['label' => 'Bảng giá', 'url' => ['page/view', 'slug' => 'bang-gia']],
                        ['label' => 'Blog', 'url' => ['news/index']],
                        ['label' => 'Hướng dẫn mua hàng', 'url' => ['page/view', 'slug' => 'huong-dan-mua-hang']],
                        ['label' => 'Liên hệ', 'url' => ['site/contact']],
                    ]
                ]) ?>
            </li>
        </ul>
    </div>
    <div class="col-sm-4">
        <ul class="mainmenu">
            <?php foreach($treeCategory as $index => $category) { ?>
                <?php if($category['show_in_menu'] && $category['id'] === 262) { ?>
                    <li class="has-submenu">
                        <?= Html::a($category['name'], ['product/category', 'id' => $category['id'], 'slug' => $category['slug']]) ?>
                        <ul class="submenu">
                            <?php foreach ($category['children'] as $child) { ?>
                                <?php if($child['show_in_menu']) { ?>
                                    <li>
                                        <?= Html::a($child['name'], ['product/category', 'id' => $child['id'], 'slug' => $child['slug']]) ?>
                                    </li>
                                <?php } ?>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>
            <?php } ?>
        </ul>
        <ul class="mainmenu">
            <li class="has-submenu">
                <a href="javascript:void(0);">Khác</a>
                <ul class="submenu">
            <?php foreach($treeCategory as $index => $category) { ?>
                <?php if($category['show_in_menu'] && $category['id'] !== 262 && $category['id'] !== 261) { ?>
                    <li>
                        <?= Html::a($category['name'],
                            ['product/category', 'id' => $category['id'], 'slug' => $category['slug']]) ?>
                    </li>
                <?php } ?>
            <?php } ?>
                </ul>
            </li>
        </ul>
    </div>
    <div class="col-sm-4">
        <ul class="mainmenu">
            <?php foreach($treeCategory as $index => $category) { ?>
                <?php if($category['show_in_menu'] && $category['id'] === 261) { ?>
                    <li class="has-submenu">
                        <?= Html::a($category['name'], ['product/category', 'id' => $category['id'], 'slug' => $category['slug']]) ?>
                        <ul class="submenu">
                            <?php foreach ($category['children'] as $child) { ?>
                                <?php if($child['show_in_menu']) { ?>
                                    <li>
                                        <?= Html::a($child['name'], ['product/category', 'id' => $child['id'], 'slug' => $child['slug']]) ?>
                                    </li>
                                <?php } ?>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>
            <?php } ?>
        </ul>
    </div>
</nav>
