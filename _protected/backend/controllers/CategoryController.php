<?php

namespace backend\controllers;

use common\helpers\SlugHelper;
use Yii;
use common\models\Category;
use common\models\CategorySearch;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends BackendController
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
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(isset(Yii::$app->request->post()['CategoryOrder']))
        {
            $categoryOrderList = Yii::$app->request->post()['CategoryOrder'];
            foreach ($categoryOrderList as $value) {
                $model = $this->findModel($value['id']);
                $model->sorting = $value['order'];
                $model->save(false);
            }

            return $this->redirect(['index']);
        }
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $result = $dataProvider->getModels();

        $resultShow = [];
        foreach($result as $item) {
            if($item->parent_id === 0) {
                $show['id'] = $item->id;
                $show['name'] = $item->name;
                $show['show_in_menu'] = $item->show_in_menu;
                $show['activated'] = $item->activated;
                $show['sorting'] = $item->sorting;
                $resultShow[] = $show;
            }
        }

        foreach($resultShow as &$itemShow) {
            $itemShow['children'] = array();
            foreach($result as $item) {
                if(intval($item->parent_id) === intval($itemShow['id'])) {
                    $itemShow['children'][] = $item;
                }
            }
        }

        return $this->render('index', [
            'result' => $resultShow
        ]);
    }

    /**
     * Displays a single Category model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Category();

        if($model->load(Yii::$app->request->post())) {
            $model->slug = $model->getSlug(SlugHelper::makeSlugs($model->name));
            $model->parent_id = intval(Yii::$app->request->post()['Category']['parent_id']);
            $model->sorting = Category::find()->select('sorting')->max('sorting') + 1;

            if ($model->save()) {
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if(isset(Yii::$app->request->post()['Category']['slug'])) {
                $model->slug = $model->getSlug(SlugHelper::makeSlugs($model->slug), $id);
            }
            else {
                if(empty($model->slug)) {
                    $model->slug = $model->getSlug(SlugHelper::makeSlugs($model->name), $id);
                }
            }
            $model->parent_id = intval(Yii::$app->request->post()['Category']['parent_id']);
            if($model->save(false)) {
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        //$this->findModel($id)->delete();
        $model = $this->findModel($id);
        $model->deleted = 1;
        $model->save(false);

        return $this->redirect(['index']);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param string $name
     * @param int $id
     * @return bool
     */
    public function actionCheckingduplicated($name, $id = 0)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($id === 0) {
            $exist = Category::findOne(['name' => $name]);
        }
        else {
            $exist = Category::findOne(['name' => $name]);
            if(is_object($exist) && $exist->id === intval($id)) {
                $exist = null;
            }
        }
        return $exist === null;
    }

    /**
     * @param $id
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionShowInMenu($id)
    {
        $model = $this->findModel($id);
        $model->show_in_menu = !$model->show_in_menu;

        $model->save(false);

        return $this->redirect(['index']);
    }

    /**
     * @param $id
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionActive($id)
    {
        $model = $this->findModel($id);
        $model->activated = !$model->activated;

        $model->save(false);

        return $this->redirect(['index']);
    }

    /**
     * @param $id
     * @param $oid
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionSwitch($id, $oid)
    {
        $model = $this->findModel($id);
        $modelOther = $this->findModel($oid);
        $tmp = $model->sorting;
        $model->sorting = $modelOther->sorting;
        $modelOther->sorting = $tmp;

        $model->save(false);
        $modelOther->save(false);

        //return $this->redirect(['index']);
        return true;
    }
}
