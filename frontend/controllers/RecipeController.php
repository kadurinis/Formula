<?php

namespace frontend\controllers;

use common\models\models\Display;
use common\models\models\History;
use common\models\models\Recipe;
use frontend\models\models\RecipeView;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class RecipeController extends Controller
{
    public function actionIndex() {
        return $this->render('index');
    }

    public function actionLists() {
        return $this->render('list', ['list' => Recipe::getList()]);
    }

    public function actionPrimary() {
        $type_id = Display::findModel()->primary_id;
        if ($active = History::findOpen()) {
            $view = new RecipeView(['recipe_id' => $active->recipe_id, 'type_id' => $type_id]);
            return $this->render('primary', ['model' => $active->recipe, 'dataProvider' => $view->search(), 'type_id' => $type_id]);
        }
        return $this->render('list', ['list' => Recipe::getList()]);
    }

    public function actionSecondary() {
        $type_id = Display::findModel()->secondary_id;
        $active = History::findOpen();
        $view = new RecipeView(['recipe_id' => $active ? $active->recipe_id : 0, 'type_id' => $type_id]);
        return $this->render('secondary', ['model' => $active ? $active->recipe : null, 'dataProvider' => $view->search(), 'type_id' => $type_id]);
    }

    public function actionBegin() {
        /** @var Recipe $model */
        $model = Recipe::findActive()->id(\Yii::$app->request->get('id'))->one();
        if ($model && $model->visible && !History::findOpen()) {
            $model->begin()->save();
        }
        return $this->redirect(['recipe/primary']);
    }

    public function actionEnd() {
        if ($model = History::findOpen()) {
            $model->complete()->save();
        }
        return $this->redirect(['recipe/primary']);
    }

    public function actionGetActive() {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return ['id' => ($model = History::findOpen()) && $model->recipe->visible ? $model->recipe_id : 0];
    }
}