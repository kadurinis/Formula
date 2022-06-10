<?php

namespace frontend\controllers;

use app\models\models\Nutrient;
use app\models\models\Section;
use app\models\models\Type;
use app\models\relations\SectionNutrient;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class AdminController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['*'],
                        'allow' => false,
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


    public function actionSectionEditor() {
        $id = \Yii::$app->request->get('id');
        /** @var Section $model */
        $model = Section::findActive()->id($id)->one();
        if ($model) {
            return $this->render('section-editor', ['section' => $model, 'exists' => $model->nutrients, 'nutrients' => Nutrient::findActive()->andWhere(['not', ['id' => ArrayHelper::getColumn($model->nutrients, 'id')]])->all()]);
        }
        throw new NotFoundHttpException('Не найдено');
    }

    public function actionAddSectionNutrient() {
        $model = new SectionNutrient();
        $model->attributes = \Yii::$app->request->queryParams;
        if ($model->save()) {
            return $this->redirect(['admin/section-editor', 'id' => $model->section_id]);
        }
        \Yii::$app->session->setFlash('error', current($model->getFirstErrors()));
        echo current($model->getFirstErrors());
    }

    public function actionDeleteSectionNutrient() {
        /** @var SectionNutrient $model */
        $model = SectionNutrient::findActive()->andWhere(['nutrient_id' => \Yii::$app->request->get('nutrient_id'), 'section_id' => \Yii::$app->request->get('section_id')])->one();
        if ($model->remove()->save()) {
            return $this->redirect(['admin/section-editor', 'id' => $model->section_id]);
        }
        \Yii::$app->session->setFlash('error', current($model->getFirstErrors()));
        echo current($model->getFirstErrors());
    }

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