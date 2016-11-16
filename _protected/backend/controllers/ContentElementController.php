<?php

namespace backend\controllers;

use common\helpers\SlugHelper;
use Yii;
use common\models\ContentElement;
use common\models\ContentElementSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * ContentElementController implements the CRUD actions for ContentElement model.
 */
class ContentElementController extends BackendController
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
     * Lists all ContentElement models.
     * @param integer $contentId
     * @return mixed
     */
    public function actionIndex($contentId)
    {
        $query = ContentElement::find();
        $query->where([
            'deleted' => 0,
            'content_id' => $contentId,
            'parent_id' => 0
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        /*$searchModel = new ContentElementSearch();
        $params = Yii::$app->request->queryParams;
        $params['content_id'] = $contentId;
        $params['deleted'] = 0;
        $dataProvider = $searchModel->search($params);*/

        $rows = $dataProvider->getModels();

        return $this->renderPartial('index', [
            'rows' => $rows,
        ]);
    }

    /**
     * Displays a single ContentElement model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return Json::encode($this->findModel($id)->content);
    }

    /**
     * Creates a new ContentElement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param integer $contentId
     * @param integer $parent_id
     * @param string $type
     * @return mixed
     */
    public function actionCreate($contentId, $type, $parent_id = 0)
    {
        $model = new ContentElement();

        $model->content_id = $contentId;
        $model->element_type = $type;
        $model->parent_id = $parent_id;

        switch($type) {
            case 'text': {
                $model->content = Json::encode([
                    'type' => 'text',
                    'value' => '',
                    'extraClass' => ''
                ]);
                break;
            }
            case 'row':
            default: {
                $model->content = Json::encode([
                    'container' => 'full',
                    'extraClass' => '',
                    'columnsType' => '[1]',
                    'columns' => [
                        [
                            'extraClass' => ''
                        ]
                    ]
                ]);
            }
        }

        $model->save(false);

        return $this->renderPartial('create-' . $type, [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ContentElement model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $content = Json::decode($model->content);

        $post = Yii::$app->request->post();
        if(!empty($post['extraClass'])) {
            $post['extraClass'] = SlugHelper::makeSlugs($post['extraClass']);
        }

        $model->content = Json::encode(array_merge($content, $post));

        $model->save(false);

        return $this->renderPartial('update-' . $model->element_type, [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ContentElement model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->deleted = 1;

        Yii::$app->response->format = Response::FORMAT_JSON;
        if($model->save(false)) {
            return Json::encode(['status' => 1]);
        }

        return Json::encode(['status' => 0]);
    }

    /**
     * Finds the ContentElement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ContentElement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ContentElement::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param $id
     * @return int
     * @throws NotFoundHttpException
     */
    public function actionActive($id)
    {
        $model = $this->findModel($id);
        $model->hide = !$model->hide;

        Yii::$app->response->format = Response::FORMAT_JSON;
        $model->save(false);

        return Json::encode(['status' => $model->hide]);
    }
}
