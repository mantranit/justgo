<?php
use backend\assets\FullAsset;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

FullAsset::register($this);
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

        <div class="wrapper">
            <div class="content">
                <?= $content ?>
            </div>
            <div class="copyright">
                2015 &copy; <?= Yii::$app->name ?>. Powered by <?= Html::a('Man Tran', 'http://www.mantrantd.com', ['target' => '_blank']) ?>
            </div>
        </div>

        <?php $this->endBody() ?>
    </div>
</body>
</html>
<?php $this->endPage() ?>
