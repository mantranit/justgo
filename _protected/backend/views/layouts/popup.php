<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\Menu;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>

    <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all">
    <script src="<?= Yii::$app->view->theme->baseUrl ?>/js/vendor/modernizr.js"></script>
    <?php $this->head() ?>
</head>
<body>
<div class="site-wrapper">
    <?php $this->beginBody() ?>
    <div class="wrapper row">
        <div class="large-12 columns content-bg">
            <div class="row">
                <main class="large-10 medium-12 small-12 columns container" role="main">
                    <?= Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                        'options' => ['class' => 'breadcrumbs']
                    ]) ?>
                    <?= $content ?>
                </main>
            </div>
        </div>
    </div>

    <?php $this->endBody() ?>
</div>
</body>
</html>
<?php $this->endPage() ?>
