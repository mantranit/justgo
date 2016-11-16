<?php
/**
 * Created by PhpStorm.
 * User: ManTran
 * Date: 6/29/2015
 * Time: 10:48 AM
 */

namespace frontend\controllers;

use common\models\Content;
use common\models\Tag;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

/**
 * Class NewsController
 * @package frontend\controllers
 */
class NewsController extends FrontendController {

    public function actionIndex()
    {
        $query = Content::find()
            ->where(['deleted' => 0, 'content_type' => Content::TYPE_NEWS, 'status' => Content::STATUS_PUBLISHED])
            ->orderBy('created_date DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Displays a single Product model.
     *
     * @param  string $slug
     * @return mixed
     */
    public function actionView($slug)
    {
        $model = $this->findModelBySlug($slug);
        $tags = Tag::find()
            ->innerJoin('tbl_content_tag', 'tbl_content_tag.tag_id = tbl_tag.id')
            ->where(['tbl_tag.deleted' => 0, 'tbl_content_tag.deleted' => 0, 'tbl_content_tag.content_id' => $model->id])
            ->all();

        return $this->render('view', [
            'model' => $model,
            'tags' => $tags
        ]);
    }

    /**
     * Displays Products by tag.
     *
     * @param  string $slug
     * @return mixed
     */
    public function actionTag($slug)
    {
        $model = $this->findTagModel($slug);
        $query = Content::find()
            ->innerJoin('tbl_content_tag', 'tbl_content_tag.content_id = tbl_content.id')
            ->where([
                'tbl_content_tag.deleted' => 0,
                'tbl_content.deleted' => 0,
                'tbl_content_tag.tag_id' => $model->id,
            ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 3,
            ],
        ]);

        return $this->render('tag', [
            'model' => $model,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * @param $slug
     * @return null|static
     * @throws NotFoundHttpException
     */
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

    /**
     * @param $slug
     * @return Tag
     * @throws NotFoundHttpException
     */
    protected function findTagModel($slug)
    {
        if (($model = Tag::findOne(['slug' => $slug])) !== null)
        {
            return $model;
        }
        else
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}