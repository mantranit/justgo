<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\assets\ArrangementAsset;

/* @var $this yii\web\View */
$this->title = Yii::t('app', Yii::$app->name);

ArrangementAsset::register($this);

?>

<article class="site-index">
    <div class="portlet">
        <div class="portlet-title">
            <div class="caption">Tổng quan hoạt động</div>
        </div>
        <div class="portlet-body">
            <div class="row">
                <div class="medium-6 columns">
                    <div class="portlet small">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-cogs"></i>Cấu hình
                            </div>
                        </div>
                        <div class="portlet-body has-padding-full">
                            <?php $form = ActiveForm::begin([
                                'id' => 'config-form'
                            ]); ?>

                            <?php foreach ($config as $index => $item) { ?>
                                <div class="form-group">
                                    <label class="control-label" for="config-item-<?= $index+1 ?>"><?= Yii::t('app', $item->key) ?></label>
                                    <?= Html::input('text', 'Config['.$item->key.']', $item->value, ['class' => 'form-control', 'id' => 'config-item-'.($index+1)]) ?>
                                </div>
                            <?php } ?>

                            <div class="action-buttons">
                                <?= Html::submitButton('Cập nhật', ['class' => 'small button radius']) ?>
                                <?= Html::a('Bỏ qua', ['index'], ['class' => 'small button secondary radius']) ?>
                            </div>

                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
                <div class="medium-6 columns">
                    <div class="portlet small">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-cogs"></i>SEO chính
                            </div>
                        </div>
                        <div class="portlet-body has-padding-full">
                            <?php $form = ActiveForm::begin([
                                'id' => 'seo-form'
                            ]); ?>

                            <?php foreach ($seo as $index => $item) { ?>
                                <div class="form-group">
                                    <label class="control-label" for="config-item-<?= $index+1 ?>"><?= Yii::t('app', $item->key) ?></label>
                                    <?= Html::textarea('Seo['.$item->key.']', $item->value, ['class' => 'form-control', 'rows' => $index+3, 'id' => 'config-item-'.($index+1)]) ?>
                                </div>
                            <?php } ?>

                            <div class="action-buttons">
                                <?= Html::submitButton('Cập nhật', ['class' => 'small button radius']) ?>
                                <?= Html::a('Bỏ qua', ['index'], ['class' => 'small button secondary radius']) ?>
                            </div>

                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="medium-6 columns">
                    <div class="portlet small">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-cogs"></i>Cấu hình Social
                            </div>
                        </div>
                        <div class="portlet-body has-padding-full">
                            <?php $form = ActiveForm::begin([
                                'id' => 'social-form'
                            ]); ?>

                            <?php foreach ($social as $index => $item) { ?>
                                <div class="form-group">
                                    <label class="control-label" for="config-item-<?= $index+1 ?>"><?= Yii::t('app', $item->key) ?></label>
                                    <?= Html::input('text', 'Social['.$item->key.']', $item->value, ['class' => 'form-control', 'id' => 'social-item-'.($index+1)]) ?>
                                </div>
                            <?php } ?>

                            <div class="action-buttons">
                                <?= Html::submitButton('Cập nhật', ['class' => 'small button radius']) ?>
                                <?= Html::a('Bỏ qua', ['index'], ['class' => 'small button secondary radius']) ?>
                            </div>

                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
                <div class="medium-6 columns">
                    <div class="portlet small">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-cogs"></i>Hỗ trợ
                            </div>
                        </div>
                        <div class="portlet-body has-padding-full">
                            <?php $form = ActiveForm::begin([
                                'id' => 'support-form'
                            ]); ?>

                            <ul class="support-config">
                            <?php foreach ($support as $index => $contact) { ?>
                                <li class="contact contact-item-<?= ($index) ?>" data-index="<?= ($index) ?>">
                                    <div class="row">
                                        <div class="form-group columns small-6">
                                            <label class="control-label"><?= Yii::t('app', 'Type') ?></label>
                                            <?= Html::dropDownList('Support['.($index).'][type]', $contact['type'], ['yahoo' => 'Yahoo', 'skype' => 'Skype'], ['class' => 'form-control']) ?>
                                        </div>
                                        <div class="form-group columns small-6">
                                            <label class="control-label"><?= Yii::t('app', 'Name') ?></label>
                                            <?= Html::textInput('Support['.($index).'][name]', $contact['name'], ['class' => 'form-control']) ?>
                                        </div>
                                        <div class="form-group columns small-6">
                                            <label class="control-label"><?= Yii::t('app', 'Nickname') ?></label>
                                            <?= Html::textInput('Support['.($index).'][nickname]', $contact['nickname'], ['class' => 'form-control']) ?>
                                        </div>
                                        <div class="form-group columns small-5">
                                            <label class="control-label"><?= Yii::t('app', 'Phone') ?></label>
                                            <?= Html::textInput('Support['.($index).'][phone]', $contact['phone'], ['class' => 'form-control']) ?>
                                        </div>
                                        <div class="form-group columns small-1">
                                            <a class="remove-suport">x</a>
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>
                            </ul>

                            <div class="action-buttons">
                                <?= Html::a('Thêm hỗ trợ', 'javascript:;', ['class' => 'add-support small button success radius']) ?>
                                <?= Html::submitButton('Cập nhật', ['name' => 'Support[submit]', 'class' => 'small button radius']) ?>
                                <?= Html::a('Bỏ qua', ['index'], ['class' => 'small button secondary radius']) ?>
                            </div>

                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</article>

