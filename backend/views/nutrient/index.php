<?php

use backend\models\search\NutrientModel;
use common\models\models\Type;
use kartik\grid\DataColumn;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use kartik\select2\Select2;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;

/**
 * @var ActiveDataProvider $dataProvider
 * @var NutrientModel $model
 */
$this->title = 'Нутриенты';
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $model,
    'resizableColumns' => false,
    'pjax' => true,
    'pjaxSettings' => [
        'options' => ['id' => 'nutrient-pjax'],
    ],
    'columns' => [
        ['class' => SerialColumn::class],
        'name:text',
        [
            'class' => DataColumn::class,
            'attribute' => 'type_id',
            'filter' => Type::getList(),
            'filterType' => GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'theme' => Select2::THEME_DEFAULT,
                'pluginOptions' => [
                    'placeholder' => '',
                    'allowClear' => true,
                    'dropdownAutoWidth' => true,
                ]
            ],
            'value' => static function (NutrientModel $model) {
                return $model->type->name;
            }
        ],
        ['attribute' => 'created_at', 'format' => ['datetime', 'php:d.m.Y H:i:s'], 'filter' => false],
        [
            'header' => 'Секции',
            'format' => 'raw',
            'value' => static function (NutrientModel $model) {
                return Html::a(count($model->sectionNutrients), ['section/index'], ['title' => 'Отсылок в секциях', 'data-pjax' => 0]);
            }
        ],
        [
            'header' => 'Рецепты',
            'format' => 'raw',
            'value' => static function (NutrientModel $model) {
                return Html::a(count($model->recipeNutrients), ['recipe/index'], ['title' => 'Отсылок в рецептах', 'data-pjax' => 0]);
            }
        ],
        [
            'header' => Html::a('', ['nutrient/edit'], ['class' => 'btn btn-success glyphicon glyphicon-plus', 'title' => 'Добавить нутриент', 'data-pjax' => 0]),
            'format' => 'raw',
            'value' => static function (NutrientModel $model) {
                return implode('&nbsp;', [
                    Html::a('', ['nutrient/edit', 'id' => $model->id], ['class' => 'glyphicon glyphicon-pencil', 'data-pjax' => 0]),
                    Html::a('', ['nutrient/delete', 'id' => $model->id], ['class' => 'glyphicon glyphicon-remove', 'data-pjax' => 0])
                ]);
            }
        ],
    ],
]) ?>
