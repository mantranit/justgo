<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 10/19/2015
 * Time: 2:23 PM
 */

use yii\helpers\Url;
use yii\helpers\Html;

?>

<nav class="nav-footer" role="navigation">
    <ul class="mainmenu login">
        <?php if(!Yii::$app->user->isGuest) { ?>
            <li>
                <i class="glyphicon glyphicon-user"></i> Chào <?= Yii::$app->user->identity->username ?> !
            </li>
            <li>
                <a href="<?= Url::toRoute(['site/change-password']) ?>" data-method="post"><i class="glyphicon glyphicon-wrench"></i> Đổi mật khẩu</a>
            </li>
            <li>
                <a href="<?= Url::toRoute(['site/logout']) ?>" data-method="post"><i class="glyphicon glyphicon-log-out"></i> Đăng xuất</a>
            </li>
            <?php
            $role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
            if(isset($role['admin'])) { ?>
                <li>
                    <?= Html::a('<i class="glyphicon glyphicon-plus"></i> Đăng ký', ['site/signup']) ?>
                </li>
            <?php } ?>
        <?php } else { ?>
            <li><a href="<?= Url::toRoute(['site/login']) ?>"><i class="glyphicon glyphicon-user"></i> Đăng nhập</a></li>
        <?php } ?>
    </ul>
    <ul class="categorymenu">
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
    <?= \yii\widgets\Menu::widget([
        'items' => [
            ['label' => 'Trang chủ', 'url' => ['site/index']],
            ['label' => 'Giới thiệu', 'url' => ['page/view', 'slug' => 'gioi-thieu']],
            ['label' => 'Bảng giá', 'url' => ['page/view', 'slug' => 'bang-gia']],
            ['label' => 'Blog', 'url' => ['news/index']],
            ['label' => 'Hướng dẫn mua hàng', 'url' => ['page/view', 'slug' => 'huong-dan-mua-hang']],
            ['label' => 'Liên hệ', 'url' => ['site/contact']],
        ],
        'options' => ['class'=>'mainmenu main']
    ]) ?>
</nav>
<p class="copy">&copy; 2015 Duy Tan Computer<br/>Powered by <a href="http://www.mantrantd.com">Man Tran</a></p>
