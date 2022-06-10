<?php

namespace backend\controllers;

use common\models\models\Display;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class DisplayController extends Controller
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
        $model = Display::findModel();
        if ($model->load(\Yii::$app->request->bodyParams) && $model->validate() && $model->save()) {
            return $this->redirect(['display/index']);
        }
        return $this->render('index', ['model' => $model]);
    }
}