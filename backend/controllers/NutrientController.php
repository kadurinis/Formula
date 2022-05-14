<?php

namespace backend\controllers;

use backend\models\search\NutrientModel;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class NutrientController extends Controller
{
    public function actionIndex() {
        $model = $this->createModel();
        return $this->render('index', ['dataProvider' => $model->search(), 'model' => $model]);
    }

    public function actionEdit() {
        $model = $this->findModel(\Yii::$app->request->get('id')) ?: $this->createModel();
        if ($model->load(\Yii::$app->request->bodyParams) && $model->validate() && $model->save()) {
            return $this->redirect(['nutrient/index']);
        }
        return $this->render('edit', ['model' => $model]);
    }

    public function actionDelete() {
        if ($model = $this->findModel(\Yii::$app->request->get('id'))) {
            if (\Yii::$app->request->get('confirm') === 'yes') {
                $model->remove()->save();
            }
        }
        return $this->render('delete', ['model' => $model, 'usage' => $model ? $model->findUsage() : []]);
    }

    protected function createModel() {
        return new NutrientModel();
    }

    protected function findModel($id) {
        return NutrientModel::findOne($id);
    }
}