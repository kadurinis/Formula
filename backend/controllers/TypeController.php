<?php

namespace backend\controllers;

use backend\models\search\TypeModel;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class TypeController extends Controller
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
        return $this->render('index', ['dataProvider' => $model->search(), 'model' => $model]);
    }

    protected function createModel() {
        return new TypeModel();
    }
}