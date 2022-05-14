<?php

namespace frontend\controllers;

use yii\web\Controller;

class RecipeController extends Controller
{
    public function actionLists() {
        return $this->render('list');
    }

    public function actionPrimary() {

    }

    public function actionSecondary() {

    }
}