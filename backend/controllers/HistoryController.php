<?php

namespace backend\controllers;

use backend\models\search\HistoryModel;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class HistoryController extends Controller
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
        $model = new HistoryModel();
        return $this->render('index', ['model' => $model, 'dataProvider' => $model->search()]);
    }
}