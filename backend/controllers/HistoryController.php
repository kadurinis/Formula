<?php

namespace backend\controllers;

use backend\models\search\HistoryModel;
use yii\web\Controller;

class HistoryController extends Controller
{
    public function actionIndex() {
        $model = new HistoryModel();
        return $this->render('index', ['model' => $model, 'dataProvider' => $model->search()]);
    }
}