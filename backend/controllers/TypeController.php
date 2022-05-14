<?php

namespace backend\controllers;

use backend\models\search\TypeModel;
use yii\web\Controller;

class TypeController extends Controller
{
    public function actionIndex() {
        $model = $this->createModel();
        return $this->render('index', ['dataProvider' => $model->search(), 'model' => $model]);
    }

    protected function createModel() {
        return new TypeModel();
    }
}