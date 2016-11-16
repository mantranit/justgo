<?php
/**
 * Created by PhpStorm.
 * User: ManTran
 * Date: 6/29/2015
 * Time: 10:48 AM
 */

namespace frontend\controllers;

use common\models\Content;
use yii\web\NotFoundHttpException;

/**
 * Class PageController
 * @package frontend\controllers
 */
class PageController extends FrontendController {

    /**
     * Displays a single Product model.
     *
     * @param  string $slug
     * @return mixed
     */
    public function actionView($slug)
    {
        return $this->render('view', [
            'model' => $this->findModelBySlug($slug)
        ]);
    }

    protected function findModelBySlug($slug) {
        if (($model = Content::findOne(['slug' => $slug])) !== null)
        {
            return $model;
        }
        else
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Finds the Content model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer  $id
     * @return Content The loaded model.
     *
     * @throws NotFoundHttpException if the model cannot be found.
     */
    protected function findModel($id)
    {
        if (($model = Content::findOne($id)) !== null)
        {
            return $model;
        }
        else
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}