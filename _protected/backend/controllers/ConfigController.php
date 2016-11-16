<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 10/21/2015
 * Time: 4:05 PM
 */

namespace backend\controllers;

use common\models\Arrangement;
use common\models\Config;
use common\models\Product;
use Yii;

class ConfigController extends BackendController
{
    /**
     * @param \yii\base\Action $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * @return string
     */
    public function actionSplashScreen() {
        if(isset(Yii::$app->request->post()['popup_content'])) {
            $value = Yii::$app->request->post()['popup_content'];
            $object = Config::findOne(['key' => 'POPUP_CONTENT']);
            $object->value = $value;
            $object->save(false);

            $value = Yii::$app->request->post()['popup_enabled'];
            $object = Config::findOne(['key' => 'POPUP_ENABLED']);
            $object->value = intval($value);
            $object->save(false);

            $value = Yii::$app->request->post()['popup_options'];
            $object = Config::findOne(['key' => 'POPUP_OPTIONS']);
            $object->value = $value;
            $object->save(false);

            $this->refresh();
        }
        else {
            return $this->render('splash-screen');
        }
    }

    /**
     * @return string
     */
    public function actionFeatured() {
        if(isset(Yii::$app->request->post()['ArrangementProduct'])) {
            $idList = explode(',', Yii::$app->request->post()['ArrangementProduct']);
            foreach ($idList as $index => $id) {
                $arrangementObject = Arrangement::findOne(['content_id' => $id, 'content_type' => Arrangement::TYPE_PRODUCT]);
                if($arrangementObject) {
                    $arrangementObject->deleted = 0;
                    $arrangementObject->sorting = $index + 1;
                }
                else {
                    $arrangementObject = new Arrangement();
                    $arrangementObject->content_type = Arrangement::TYPE_PRODUCT;
                    $arrangementObject->content_id = $id;
                    $arrangementObject->sorting = $index + 1;
                }
                $arrangementObject->save(false);
            }
            $arrangementObjects = Arrangement::findAll(['content_type'=>Arrangement::TYPE_PRODUCT]);
            foreach ($arrangementObjects as $object) {
                if(!in_array($object->content_id, $idList)){
                    $object->deleted = 1;
                    $object->save(false);
                }
            }
            $this->redirect('featured');
        }
        else {
            $productArrangements = Product::find()->innerJoin('tbl_arrangement', 'tbl_product.id = tbl_arrangement.content_id')
                ->where(["tbl_product.deleted" => 0, "tbl_arrangement.deleted" => 0, "content_type" => Arrangement::TYPE_PRODUCT])
                ->orderBy('sorting')->all();
            $idList = [];
            foreach ($productArrangements as $index => $product) {
                array_push($idList, $product->id);
            }

            $productSuggestion = Product::find()->where(["AND", "deleted = 0", ["NOT IN", "id", $idList]])->orderBy('published_date DESC')->all();
            return $this->render('featured', [
                'products' => $productArrangements,
                'productSuggestion' => $productSuggestion
            ]);
        }
    }
}