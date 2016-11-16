<?php

namespace backend\controllers;

use common\helpers\CurrencyHelper;
use common\helpers\SlugHelper;
use common\models\Category;
use common\models\CategorySearch;
use common\models\File;
use common\models\FileSearch;
use common\models\ProductCategory;
use common\models\ProductFile;
use common\models\ProductRelated;
use common\models\ProductTag;
use common\models\Tag;
use common\models\TagSearch;
use Yii;
use common\models\Product;
use common\models\ProductSearch;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends BackendController
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
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
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
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param string $name
     * @return mixed
     */
    public function actionCreate($name)
    {
        $model = new Product();

        $model->name = $name;
        $model->slug = $model->getSlug(SlugHelper::makeSlugs($name));
        $model->status = Product::STATUS_DRAFT;
        $model->created_date = time();
        $model->created_by = Yii::$app->user->identity->username;

        if($model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        }
        else {
            return $this->redirect(['index']);
        }
    }

    /**
     * @param $productId
     * @param $categoryString
     * @return void
     */
    protected function updateCategory($productId, $categoryString)
    {
        $categoryList = [];
        if(!empty($categoryString))
        {
            foreach (Json::decode('[' . $categoryString . ']') as $categoryId) {
                array_push($categoryList, $categoryId);

                $productCategoryObject = ProductCategory::findOne(['product_id'=>$productId, 'category_id'=>$categoryId]);
                if($productCategoryObject !== null) {
                    $productCategoryObject->deleted = 0;
                } else {
                    $productCategoryObject = new ProductCategory();
                    $productCategoryObject->product_id = $productId;
                    $productCategoryObject->category_id = $categoryId;
                }
                $productCategoryObject->save(false);
            }

        }

        $productCategoryObjects = ProductCategory::findAll(['product_id'=>$productId]);
        foreach ($productCategoryObjects as $object) {
            if(!in_array($object->category_id, $categoryList)){
                $object->deleted = 1;
                $object->save(false);
            }
        }
    }

    /**
     * @param int $productId
     * @param array $pictureData
     * @return void
     */
    protected function updatePicture($productId, $pictureData)
    {
        $fileList = [];
        if(is_array($pictureData)) {
            foreach ($pictureData as $index => $value) {
                if (($modelFile = File::findOne(intval($value['id']))) !== null) {
                    if (!empty($value['caption'])) {
                        $modelFile->caption = $value['caption'];
                    }
                    $modelFile->deleted = 0;
                    $modelFile->save(false);
                    array_push($fileList, $modelFile->id);

                    if (($modelProductFile = ProductFile::findOne(['product_id' => $productId, 'file_id' => intval($value['id'])])) !== null) {
                        $modelProductFile->deleted = 0;
                    } else {
                        $modelProductFile = new ProductFile();
                        $modelProductFile->product_id = $productId;
                        $modelProductFile->file_id = $modelFile->id;
                    }
                    $modelProductFile->save(false);
                }
            }
        }

        $productFileObjects = ProductFile::findAll(['product_id'=>$productId]);
        foreach ($productFileObjects as $object) {
            if(!in_array($object->file_id, $fileList)){
                $object->delete();
            }
        }
    }

    /**
     * @param int $productId
     * @param string $tagString
     * @return void
     */
    protected function updateTags($productId, $tagString)
    {
        $tagList = [];
        if(!empty($tagString))
        {
            foreach (Json::decode($tagString) as $tagName) {
                $tagObject = Tag::findOne(['name' => $tagName]);
                if($tagObject !== null) {
                    $tagObject->deleted = 0;
                } else {
                    $tagObject = new Tag();
                    $tagObject->name = $tagName;
                    $tagObject->slug = $tagObject->getSlug(SlugHelper::makeSlugs($tagName));
                }
                $tagObject->save(false);
                array_push($tagList, $tagObject->id);

                $productTagObject = ProductTag::findOne(['product_id'=>$productId, 'tag_id'=>$tagObject->id]);
                if($productTagObject !== null) {
                    $productTagObject->deleted = 0;
                } else {
                    $productTagObject = new ProductTag();
                    $productTagObject->product_id = $productId;
                    $productTagObject->tag_id = $tagObject->id;
                }
                $productTagObject->save(false);
            }

        }

        $productTagObjects = ProductTag::findAll(['product_id'=>$productId]);
        foreach ($productTagObjects as $object) {
            if(!in_array($object->tag_id, $tagList)){
                $object->deleted = 1;
                $object->save(false);
            }
        }
    }

    /**
     * @param int $productId
     * @param string $relatedString
     * @return void
     */
    protected function updateRelated($productId, $relatedString)
    {

        $relatedList = [];
        if(!empty($relatedString))
        {
            foreach (explode(',', $relatedString) as $index => $relatedId) {
                array_push($relatedList, $relatedId);

                $productRelatedObject = ProductRelated::findOne(['product_id'=>$productId, 'related_id'=>$relatedId]);
                if($productRelatedObject !== null) {
                    $productRelatedObject->deleted = 0;
                    $productRelatedObject->sorting = $index;
                } else {
                    $productRelatedObject = new ProductRelated();
                    $productRelatedObject->product_id = $productId;
                    $productRelatedObject->related_id = $relatedId;
                    $productRelatedObject->sorting = $index;
                }
                $productRelatedObject->save(false);
            }

        }

        $productRelatedObjects = ProductRelated::findAll(['product_id'=>$productId]);
        foreach ($productRelatedObjects as $object) {
            if(!in_array($object->related_id, $relatedList)){
                $object->deleted = 1;
                $object->save(false);
            }
        }
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if(isset(Yii::$app->request->post()['Product']['slug'])) {
                $model->slug = $model->getSlug(SlugHelper::makeSlugs($model->slug), $id);
            }
            else {
                if(empty($model->slug) || $model->updated_date === 0) {
                    $model->slug = $model->getSlug(SlugHelper::makeSlugs($model->name), $id);
                }
            }
            if(intval(Yii::$app->request->post()['type-submit']) === 1) {
                if($model->status !== Product::STATUS_INSTOCK) {
                    $model->status = Product::STATUS_INSTOCK;
                    $model->published_date = time();
                }
            }
			if(isset(Yii::$app->request->post()['Product']['status'])) {
                $model->status = Yii::$app->request->post()['Product']['status'];
            }
            if(isset(Yii::$app->request->post()['Product']['discount'])) {
                $model->discount = CurrencyHelper::toNumber(Yii::$app->request->post()['Product']['discount']);
            }
            if(isset(Yii::$app->request->post()['Price'])) {
                $priceData = Yii::$app->request->post()['Price'];
                $model->price_string = Json::encode($priceData);
                $model->price = CurrencyHelper::toNumber($priceData['month3']['current']);
            }
            if($model->save()) {
                $this->updateCategory($model->id, isset(Yii::$app->request->post()['Category']) ? Yii::$app->request->post()['Category'] : '');
                $this->updatePicture($model->id, isset(Yii::$app->request->post()['Picture']) ? Yii::$app->request->post()['Picture'] : []);
                $this->updateTags($model->id, isset(Yii::$app->request->post()['Tag']) ? Yii::$app->request->post()['Tag'] : '');
                $this->updateRelated($model->id, isset(Yii::$app->request->post()['Related']) ? Yii::$app->request->post()['Related'] : '');
                return $this->redirect(['update', 'id' => $model->id]);
            }
        } else {
            $dataProvider = new FileSearch();
            $pictures = $dataProvider->search(['product_id' => $id])->getModels();

            $dataProvider = new CategorySearch();
            $categories = $dataProvider->search(['product_id' => $id])->getModels();
            $categoryList = [];
            foreach ($categories as $category) {
                array_push($categoryList, $category->id);
            }

            $dataProvider = new TagSearch();
            $tags= $dataProvider->search(['product_id' => $id])->getModels();
            $tagList = [];
            foreach ($tags as $tag) {
                array_push($tagList, $tag->name);
            }

            $dataProvider = new TagSearch();
            $tagObjects = $dataProvider->search([])->getModels();
            $tagSuggestions = '';
            foreach ($tagObjects as $obj) {
                $tagSuggestions .= $obj->name . ',';
            }
            $tagSuggestions = rtrim($tagSuggestions, ',');

            $productSearch = new ProductSearch();
            $products = $productSearch->search(['product_id' => $id])->getModels();
            $idList = [$id];
            foreach ($products as $index => $product) {
                array_push($idList, $product->id);
            }

            $productSuggestion = Product::find()->where(["AND", "deleted = 0", ["NOT IN", "id", $idList]])->orderBy('published_date DESC')->all();

            if(empty($model->price_string)){
                $model->price_string = Json::encode([
                    'month3' => [
                        'current' => CurrencyHelper::formatNumber(0),
                        'old' => CurrencyHelper::formatNumber(0)
                    ],
                    'month12' => [
                        'current' => CurrencyHelper::formatNumber(0),
                        'old' => CurrencyHelper::formatNumber(0)
                    ]
                ]);
            }

            return $this->render('update', [
                'model' => $model,
                'pictures' => $pictures,
                'categories' => Json::encode($categoryList),
                'tags' => Json::encode($tagList),
                'tagSuggestions' => $tagSuggestions,
                'products' => $products,
                'productSuggestion' => $productSuggestion
            ]);
        }
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        //$this->findModel($id)->delete();
        $model = $this->findModel($id);
        $model->deleted = 1;
        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * @param $id
     * @param int $ajax
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionActive($id, $ajax = 0) {
        $model = $this->findModel($id);
        $model->activated = intval(!$model->activated);
        $model->save();

        if($ajax) {
            return true;
        }
        else {
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
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
            $exist = Product::findOne(['name' => $name]);
        }
        else {
            $exist = Product::findOne(['name' => $name]);
            if(is_object($exist) && $exist->id === intval($id)) {
                $exist = null;
            }
        }
        return $exist === null;
    }
}
