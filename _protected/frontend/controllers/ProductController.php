<?php
/**
 * Created by PhpStorm.
 * User: ManTran
 * Date: 6/29/2015
 * Time: 10:48 AM
 */

namespace frontend\controllers;

use Yii;
use common\models\Category;
use common\models\FileSearch;
use common\models\Product;
use common\models\Tag;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class ProductController extends FrontendController {

    /**
     * Displays a single Product model.
     *
     * @param  integer $id
     * @param  string $slug
     * @return mixed
     */
    public function actionView($id, $slug)
    {
        $dataProvider = new FileSearch();
        $pictures = $dataProvider->search(['product_id' => $id])->getModels();

        $categories = Category::find()
            ->innerJoin('tbl_product_category', 'tbl_product_category.category_id = tbl_category.id')
            ->where(['tbl_category.deleted' => 0, 'tbl_product_category.deleted' => 0, 'tbl_product_category.product_id' => $id])
            ->all();
        $category = null;
        if(count($categories) > 0) {
            $flag = true;
            foreach ($categories as $object) {
                if($object->parent_id > 0) {
                    $flag = false;
                    $category = $object;
                    break;
                }
            }
            if($flag) {
                $category = $categories[0];
            }
        }

        $relatedList = Product::find()
            ->innerJoin('tbl_product_related', 'tbl_product_related.related_id = tbl_product.id')
            ->where([
                'tbl_product.activated' => 1,
                'tbl_product.deleted' => 0,
                'tbl_product.status' => Product::isShowing(),
                'tbl_product_related.deleted' => 0,
                'tbl_product_related.product_id' => $id
            ])
            ->orderBy('sorting')->all();
        if(count($relatedList) === 0) {
            $relatedList = Product::find()
                ->innerJoin('tbl_product_category', 'tbl_product_category.product_id = tbl_product.id')
                ->where([
                    'tbl_product.activated' => 1,
                    'tbl_product.deleted' => 0,
                    'tbl_product.status' => Product::isShowing(),
                    'tbl_product_category.deleted' => 0,
                    'tbl_product_category.category_id' => $category->id
                ])
                ->andWhere(['!=', 'tbl_product.id', $id])
                ->orderBy('price DESC')->all();
        }
        $tags = Tag::find()
            ->innerJoin('tbl_product_tag', 'tbl_product_tag.tag_id = tbl_tag.id')
            ->where(['tbl_tag.deleted' => 0, 'tbl_product_tag.deleted' => 0, 'tbl_product_tag.product_id' => $id])
            ->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'pictures' => $pictures,
            'tags' => $tags,
            'category' => $category,
            'relatedList' => $relatedList
        ]);
    }

    /**
     * Displays Products by category.
     *
     * @param  integer $id
     * @param  string $slug
     * @return mixed
     */
    public function actionCategory($id, $slug)
    {
        $model = $this->findCategoryModel($id);
        if($model->parent_id === 0) {
            $query = Product::getProductByParentCategory($model->id);
        }
        else {
            $query = Product::getProductByChildCategory($model->id);
        }
        $orderBy = Yii::$app->getRequest()->getQueryParam('orderby');
        switch($orderBy) {
            case 'az':{
                $query->orderBy('tbl_product.name ASC');
                break;
            }
            case 'za':{
                $query->orderBy('tbl_product.name DESC');
                break;
            }
            case 'gg':{
                $query->orderBy('tbl_product.price DESC');
                break;
            }
            case 'gt':
            default: {
                $query->orderBy('tbl_product.status DESC, tbl_product.price ASC');
                break;
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 12,
            ],
        ]);

        return $this->render('category', [
            'model' => $model,
            'dataProvider' => $dataProvider
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
        $query = Product::find()
            ->innerJoin('tbl_product_tag', 'tbl_product_tag.product_id = tbl_product.id')
            ->where([
                'tbl_product_tag.deleted' => 0,
                'tbl_product.activated' => 1,
                'tbl_product.deleted' => 0,
                'tbl_product.status' => Product::isShowing(),
                'tbl_product_tag.tag_id' => $model->id,
            ]);

        $orderBy = Yii::$app->getRequest()->getQueryParam('orderby');
        switch($orderBy) {
            case 'gt':{
                $query->orderBy('tbl_product.price ASC');
                break;
            }
            case 'az':{
                $query->orderBy('tbl_product.name ASC');
                break;
            }
            case 'za':{
                $query->orderBy('tbl_product.name DESC');
                break;
            }
            case 'gg':
            default: {
                $query->orderBy('tbl_product.price DESC');
                break;
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 12,
            ],
        ]);

        return $this->render('tag', [
            'model' => $model,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer  $id
     * @return Product The loaded model.
     *
     * @throws NotFoundHttpException if the model cannot be found.
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null)
        {
            return $model;
        }
        else
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param $id
     * @return Category
     * @throws NotFoundHttpException
     */
    protected function findCategoryModel($id)
    {
        if (($model = Category::findOne($id)) !== null)
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