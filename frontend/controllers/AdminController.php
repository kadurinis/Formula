<?php

namespace frontend\controllers;

use app\models\models\Nutrient;
use app\models\models\Section;
use app\models\models\Type;
use yii\web\Controller;

class AdminController extends Controller
{
    public function actionLists($type = null, $section = null, $nutrient = null) {
        $type = $type ?: new Type();
        $section = $section ?: new Section();
        $nutrient = $nutrient ?: new Nutrient();
        return $this->render('lists', compact('type', 'section', 'nutrient'));
    }

    protected function addToList($model) {
        $model->load(\Yii::$app->request->bodyParams);
        if ($model->save()) {
            \Yii::$app->session->setFlash('success', 'Успешно добавлено');
        }
        return $model;
    }

    public function actionAddType() {
        return $this->actionLists($this->addToList(new Type()));
    }

    public function actionAddSection() {
        return $this->actionLists(null, $this->addToList(new Section()));
    }

    public function actionAddNutrient() {
        return $this->actionLists(null, null, $this->addToList(new Nutrient()));
    }

    public function actionDeleteFromList() {
        $class = \Yii::$app->request->get('model');
        $id = \Yii::$app->request->get('id');
        if (class_exists($class) && ($model = $class::findOne($id)) && method_exists($model, 'remove')) {
            if ($model->remove()->save()) {
                \Yii::$app->session->setFlash('success', 'Успешно удалено');
            }else {
                \Yii::$app->session->setFlash('error', current($model->getFirstErrors()));
            }
        }else {
            \Yii::$app->session->setFlash('error', 'Ошибка удаления');
        }
        return $this->redirect(['admin/lists']);
    }
}