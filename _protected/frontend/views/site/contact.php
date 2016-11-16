<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use common\models\Config;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

$this->title = 'Liên hệ | ' . Config::findOne(['key' => 'SEO_TITLE'])->value;
$this->registerMetaTag(['name' => 'author', 'content' => Yii::$app->name]);
$this->registerMetaTag(['name' => 'keywords', 'content' => Config::findOne(['key' => 'SEO_KEYWORD'])->value]);
$this->registerMetaTag(['name' => 'description', 'content' => Config::findOne(['key' => 'SEO_DESCRIPTION'])->value]);

?>

<div class="row" role="article">
    <div class="col-md-12 main-container">
        <ul class="breadcrumb">
            <li><a href="<?= Yii::$app->homeUrl ?>" class="homepage-link" title="Quay lại trang chủ"><i class="glyphicon glyphicon-home"></i> Trang chủ</a></li>
            <li><span class="page-title">Liên hệ</span></li>
        </ul>
        <div class="module-content page-detail form-page">
            <h1>Liên hệ</h1>
            <div class="page-content">
                <div id="map-canvas"></div>
                <div class="widget">
                    <header><h2>Email cho chúng tôi</h2></header>
                    <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
                    <div class="content-widget">
                        <?= $form->field($model, 'name', ['options' => ['class' => 'col-sm-12 form-group']]) ?>
                        <?= $form->field($model, 'email', ['options' => ['class' => 'col-sm-12 form-group']]) ?>
                        <?= $form->field($model, 'subject', ['options' => ['class' => 'col-sm-12 form-group']]) ?>
                        <?= $form->field($model, 'body', ['options' => ['class' => 'col-sm-12 form-group']])->textArea(['rows' => 6]) ?>
                        <?= $form->field($model, 'verifyCode', ['options' => ['class' => 'col-sm-6 form-group']])
                            ->widget(Captcha::className(), [
                                'template' => '{image}<div class="clearfix"></div>{input}'
                            ]) ?>
                        <div class="col-sm-6 form-group buttons">
                            <?= Html::submitButton(Yii::t('app', 'Gởi mail'), ['class' => 'btn btn-primary radius', 'name' => 'contact-button']) ?>
                            &nbsp;
                            <input type="reset" value="Bỏ qua" class="btn btn-info">
                        </div>
                    </div><!-- contactFormWrapper -->
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

</script>
<?php

$this->registerJsFile('https://maps.googleapis.com/maps/api/js?key=' . Config::findOne(['key' => 'GOOGLE_API_KEY'])->value . '&callback=initMap');
$this->registerJs("
var map;
function initMap() {
    map = new google.maps.Map(document.getElementById('map-canvas'), {
        center: {
            lat: " . Config::findOne(['key' => 'LATITUDE'])->value . ",
            lng: " . Config::findOne(['key' => 'LONGITUDE'])->value . "
        },
        zoom: 17,
        scrollwheel: false
    });
    var marker = new google.maps.Marker({
        position: {
            lat: " . Config::findOne(['key' => 'LATITUDE'])->value . ",
            lng: " . Config::findOne(['key' => 'LONGITUDE'])->value . "
        },
        map: map,
        title: 'DUY TÂN COMPUTER',
        zIndex: 1
    });
}
", \yii\web\View::POS_BEGIN);