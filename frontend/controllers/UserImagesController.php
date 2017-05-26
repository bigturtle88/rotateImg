<?php

namespace frontend\controllers;

use frontend\components\ImageManager;
use Yii;
use frontend\models\UserImages;
use frontend\models\UserImagesForm;
use frontend\models\UserImagesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\imagine\Image;
use yii\helpers\Url;

/**
 * UserImagesController implements the CRUD actions for UserImages model.
 */
class UserImagesController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'rotate' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all UserImages models and uploads image.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $modelImages = new UserImagesForm();
        if ($modelImages->load(Yii::$app->request->post())) {
            Yii::createObject(ImageManager::class, [$modelImages])->upload();
            return $this->refresh();
        }
        return $this->renderList();
    }

    /**
     * @param $id
     * @return mixed|\yii\web\Response
     */
    public function actionRotate($id)
    {
        $model = $this->findModel($id);
        Yii::createObject(ImageManager::class, [$model])->rotate();

        if (Yii::$app->request->isAjax)
            return $this->renderList();
        else
            return $this->redirect(['index']);

    }

    /**
     * Deletes an existing UserImages model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        if (Yii::$app->request->isAjax)
            return $this->renderList();
        else
            return $this->redirect(['index']);

    }

    /**
     * Finds the UserImages model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserImages the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserImages::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Lists all UserImages models.
     * @return mixed
     */
    protected function renderList()
    {
        $searchModel = new UserImagesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $modelImages = new UserImagesForm();
        $dataProvider->sort->route = Url::toRoute(['index']);

        $method = Yii::$app->request->isAjax ? 'renderAjax' : 'render';

        return $this->$method('index', [
            'dataProvider' => $dataProvider,
            'modelImages' =>  $modelImages,
        ]);
    }
}
