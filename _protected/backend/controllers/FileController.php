<?php

namespace backend\controllers;

use common\helpers\UtilHelper;
use Yii;
use common\models\File;
use common\models\FileSearch;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use yii\imagine\Image;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Request;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * FileController implements the CRUD actions for File model.
 */
class FileController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

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
     * Lists all File models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FileSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single File model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new File model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionUploadimage()
    {
        $mediaType = File::MEDIA_IMAGE;

        // Chunking might be enabled
        $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
        $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;

        $object = UtilHelper::upload($_FILES['file'], $mediaType, $chunk, $chunks);

        if($object) {
            $model = new File();
            $model->name = $object->fileName;
            $model->media = $mediaType;
            $model->show_url = $object->fileUrl;
            $model->directory = $object->fileDir;
            $model->file_name = $object->fileName;
            $model->file_type = $_FILES['file']['type'];
            $model->file_ext = $object->fileExt;

            $size = getimagesize($object->filePath);
            $model->dimension = $size[0] . 'x' . $size[1];
            $model->width = $size[0];
            $model->height = $size[1];
            $model->deleted = 1;

            $model->save(false);

            // Return Success JSON-RPC response
            die('{"jsonrpc" : "2.0", "result" : {"showUrl": "'.$model->show_url.'", "fileName": "'.$model->file_name.'", "fileExt":"'.$model->file_ext.'"}, "id" : '.$model->id.'}');
        }
        // Return error JSON-RPC response
        die('{"jsonrpc" : "2.0", "error" : {"code": 104, "message": "Failed to write in file."}, "id" : 0}');

    }

    /**
     * @param int $id
     */
    public function actionProcessimage($id)
    {
        $model = $this->findModel($id);

        $fileSource = Yii::getAlias('@uploads') . $model->directory . $model->file_name . '.' . $model->file_ext;
        $sizeAfterGenerate = UtilHelper::generateImage($fileSource, $fileSource);
        if($sizeAfterGenerate)
        {
            $model->dimension = $sizeAfterGenerate->getWidth() . 'x' . $sizeAfterGenerate->getHeight();
            $model->width = $sizeAfterGenerate->getWidth();
            $model->height = $sizeAfterGenerate->getHeight();

            foreach (Yii::$app->params['image_sizes'] as $key => $value) {
                $thumbnail = Yii::getAlias('@uploads') . $model->directory . $model->file_name . '-' . $key . '.' . $model->file_ext;
                UtilHelper::generateImage($fileSource, $thumbnail, $value[0], $value[1]);
            }
        } else {
            die('{"jsonrpc" : "2.0", "error" : {"code": 104, "message": "Failed to resize image."}, "id" : '.$model->id.'}');
        }

        die('{"jsonrpc" : "2.0", "result" : {"showUrl": "'.$model->show_url.'", "fileName": "'.$model->file_name.'", "fileExt":"'.$model->file_ext.'"}, "id" : '.$model->id.'}');
    }

    /**
     * @param integer $id
     * @return string
     */
    public function actionWatermask($id){
        $this->layout = 'popup';

        $model = $this->findModel($id);
        $fileSource = Yii::getAlias('@uploads') . $model->directory . DIRECTORY_SEPARATOR . $model->file_name . '-origin.' . $model->file_ext;
        $fileTarget = Yii::getAlias('@uploads') . $model->directory . DIRECTORY_SEPARATOR . $model->file_name . '.' . $model->file_ext;
        if(!file_exists($fileSource)) {
            $imagine = Image::thumbnail($fileTarget, $model->width, $model->height);
            $imagine->save($fileSource);
        }
        return $this->render('watermask', [
            'model' => $model
        ]);
    }

    /**
     * @param integer $id
     * @return string
     */
    public function actionWatermaskSave($id){
        $model = $this->findModel($id);

        $fabric = Yii::$app->request->post()['fabric'];
        $json = Json::decode($fabric);
        $fileSource = Yii::getAlias('@uploads') . $model->directory . DIRECTORY_SEPARATOR . $model->file_name . '-origin.' . $model->file_ext;
        $fileTarget = Yii::getAlias('@uploads') . $model->directory . DIRECTORY_SEPARATOR . $model->file_name . '.' . $model->file_ext;

        if(isset($json['objects']) && count($json['objects']) > 0)
        {
            foreach ($json['objects'] as $index => $mask) {
                if($index > 0) {
                    $fileSource = $fileTarget;
                }
                if($mask['type'] === 'image') {
                    UtilHelper::watermaskImage($fileSource, $fileTarget, $mask);
                }
                else {
                    UtilHelper::watermaskText($fileSource, $fileTarget, $mask);
                }
            }
        }
        else {
            $imagine = Image::thumbnail($fileSource, $model->width, $model->height);
            $imagine->save($fileTarget);
        }
        foreach (Yii::$app->params['image_sizes'] as $key => $value) {
            $fileTarget2 = Yii::getAlias('@uploads') . $model->directory . DIRECTORY_SEPARATOR . $model->file_name . '-' . $key . '.' . $model->file_ext;
            UtilHelper::generateImage($fileTarget, $fileTarget2, $value[0], $value[1]);
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        return ['src' => UtilHelper::getPicture($model, '', true) . '?time=' . time()];
    }

    /**
     * Updates an existing File model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing File model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $directory = rtrim(Yii::getAlias('@uploads') . $model->directory, DIRECTORY_SEPARATOR);
        if(UtilHelper::delTree($directory)) {
            $model->delete();
            die('{"jsonrpc" : "2.0", "result" : "The item was deleted", "id" : '.$model->id.'}');
        }

        die('{"jsonrpc" : "2.0", "error" : {"code": 104, "message": "Failed to delete image directory."}, "id" : '.$model->id.'}');
    }

    /**
     * Finds the File model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return File the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = File::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
