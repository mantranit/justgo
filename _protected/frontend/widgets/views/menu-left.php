<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 10/16/2015
 * Time: 1:30 PM
 */

use yii\helpers\Html;

?>

<nav class="nav-left" role="navigation">
    <header><h3 class="title">DANH MỤC SẢN PHẨM</h3></header>
    <ul class="mainmenu">
        <?php foreach($treeCategory as $index => $category) { ?>
            <?php if($category['show_in_menu']) { ?>
                <?php if(count($category['children']) > 0) { ?>
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
                <?php } else { ?>
                    <li>
                        <?= Html::a($category['name'],
                            ['product/category', 'id' => $category['id'], 'slug' => $category['slug']]) ?>
                    </li>
                <?php } ?>
            <?php } ?>
        <?php } ?>
    </ul>
</nav>
