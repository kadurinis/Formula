<?php

namespace backend\controllers;

use common\models\models\Display;
use yii\web\Controller;

class DisplayController extends Controller
{
    public function actionIndex() {
        $model = Display::findModel();
        if ($model->load(\Yii::$app->request->bodyParams) && $model->validate() && $model->save()) {
            return $this->redirect(['display/index']);
        }
        return $this->render('index', ['model' => $model]);
    }
}