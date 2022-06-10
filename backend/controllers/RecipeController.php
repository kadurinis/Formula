<?php

namespace backend\controllers;

use backend\models\search\RecipeActiveRow;
use backend\models\search\RecipeModel;
use backend\models\search\RecipeWarning;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class RecipeController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex() {
        $model = $this->createModel();
        $warning = new RecipeWarning();
        return $this->render('index', ['dataProvider' => $model->search(), 'model' => $model, 'warnings' => $warning->getModels('recipe_id')]);
    }

    public function actionEdit() {
        $model = $this->findModel(\Yii::$app->request->get('id')) ?: $this->createModel();
        if ($model->load(\Yii::$app->request->bodyParams) && $model->validate() && $model->save()) {
            return $this->redirect(['recipe/index']);
        }
        return $this->render('edit', ['model' => $model]);
    }

    public function actionDelete() {
        if ($model = $this->findModel(\Yii::$app->request->get('id'))) {
            if (\Yii::$app->request->get('confirm') === 'yes' && $model->remove()->save()) {
                \Yii::$app->session->setFlash('success', 'Рецепт удален');
                return $this->redirect(['recipe/delete', 'id' => \Yii::$app->request->get('id')]);
            }
        }
        return $this->render('delete', ['model' => $model]);
    }

    public function actionView() {
        if ($model = $this->findModel(\Yii::$app->request->get('id'))) {
            $warning = new RecipeWarning();
            return $this->render('view', ['model' => $model, 'models' => $model->getRowModel()->getModelsPerType(), 'warnings' => $warning->getModels('id')]);
        }
        throw new NotFoundHttpException();
    }

    public function actionPreview() {
        if ($model = $this->findModel(\Yii::$app->request->get('id'))) {
            return $this->render('preview', ['model' => $model]);
        }
        throw new NotFoundHttpException();
    }

    public function actionChangeRow() {
        $model = RecipeActiveRow::findModel(\Yii::$app->request->post());
        if (is_a($model,RecipeActiveRow::class) && $model->save()) {
            return 'ok';
        }
        \Yii::$app->response->statusCode = 400;
        return current($model->getFirstErrors()) ?: 'Ошибка';
    }

    public function actionShow() {
        return $this->visible($this->findModel(\Yii::$app->request->get('id')), RecipeModel::VISIBLE);
    }

    public function actionHide() {
        return $this->visible($this->findModel(\Yii::$app->request->get('id')), RecipeModel::INVISIBLE);
    }

    public function actionCopy() {
        if ($model = $this->findModel(\Yii::$app->request->get('id'))) {
            $copy = $model->copy();
            if (is_string($copy)) {
                \Yii::$app->session->setFlash('error', $copy);
            }
        }
        return $this->redirect(['recipe/index']);
    }

    protected function visible($model, $val) {
        if ($model) {
            $model->visible = $val;
            $model->save();
        }else {
            \Yii::$app->session->setFlash('error', 'Не найдена модель');
        }
        return $this->redirect(['recipe/index']);
    }

    protected function createModel() {
        return new RecipeModel();
    }

    protected function findModel($id) {
        return RecipeModel::findOne($id);
    }
}