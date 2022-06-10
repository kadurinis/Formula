<?php

namespace backend\controllers;

use backend\models\search\NutrientModel;
use backend\models\search\SectionModel;
use backend\models\search\SectionNutrientModel;
use backend\models\search\SectionWarning;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class SectionController extends Controller
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
        $warning = new SectionWarning();
        return $this->render('index', ['dataProvider' => $model->search(), 'model' => $model, 'warnings' => $warning->getModels()]);
    }

    public function actionEdit() {
        $model = $this->findModel(\Yii::$app->request->get('id')) ?: $this->createModel();
        if ($model->load(\Yii::$app->request->bodyParams) && $model->validate() && $model->save()) {
            return $this->redirect(['section/index']);
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

    public function actionNutrients() {
        if ($model = $this->findModel(\Yii::$app->request->get('id'))) {
            return $this->render('nutrients', ['model' => $model, 'available' => $model->getAvailable(), 'bound' => $model->getBound()]);
        }
        throw new NotFoundHttpException();
    }

    public function actionView() {
        $model = new SectionNutrientModel();
        return $this->render('nutrients', ['model' => $model, 'dataProvider' => $model->search()]);
    }

    public function actionBindNutrient() {
        $model = new SectionNutrientModel();
        if (!$model->load(\Yii::$app->request->queryParams) || !$model->validate() || !$model->save()) {
            \Yii::$app->session->setFlash('error', $model->hasErrors() ? current($model->getFirstErrors()) : 'Ошибка');
        }
        return $this->redirect(['section/nutrients', 'id' => $model->section_id]);
    }

    public function actionReleaseNutrient() {
        $model = new SectionNutrientModel();
        if (!$model->load(\Yii::$app->request->queryParams) || !($model = $model->findExist()) || !$model->remove()->save()) {
            \Yii::$app->session->setFlash('error', $model && $model->hasErrors() ? current($model->getFirstErrors()) : 'Ошибка');
        }
        return $this->redirect(['section/nutrients', 'id' => $model->section_id]);
    }

    protected function createModel() {
        return new SectionModel();
    }

    protected function findModel($id) {
        return SectionModel::findOne($id);
    }
}