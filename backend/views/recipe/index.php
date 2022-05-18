<?php
/**
 * @var View $this
 * @var ActiveDataProvider $dataProvider
 * @var SectionModel $model
 * @var array $warnings
 */

use backend\models\search\RecipeModel;
use backend\models\search\SectionModel;
use backend\models\search\TypeModel;
use kartik\grid\DataColumn;
use kartik\grid\ExpandRowColumn;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use kartik\select2\Select2;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\web\View;
$this->registerCss('.invisible-recipe {opacity: 0.4}');
$this->title = 'Рецепты';
?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $model,
    'resizableColumns' => false,
    'pjax' => true,
    'pjaxSettings' => [
        'options' => ['id' => 'recipe-pjax'],
    ],
    'rowOptions' => static function (RecipeModel $model) use ($warnings) {
        if (!$model->visible) {
            return ['class' => 'invisible-recipe'];
        }
        return isset($warnings[$model->id]) ? ['class' => 'danger', 'title' => $warnings[$model->id]] : [];
    },
    'columns' => [
        ['class' => SerialColumn::class],
        'name:text',
        'field:text',
        'percent:text',
        ['attribute' => 'created_at', 'format' => ['datetime', 'php:d.m.Y H:i:s']],
        [
            'header' => Html::a('', ['recipe/edit'], ['class' => 'btn btn-success glyphicon glyphicon-plus', 'title' => 'Добавить рецепт', 'data-pjax' => 0]),
            'width' => '3%',
            'format' => 'raw',
            'contentOptions' => ['style' => 'white-space: nowrap'],
            'value' => static function (RecipeModel $model) {
                return implode('&nbsp;&nbsp;', [
                    Html::a('', ['recipe/preview', 'id' => $model->id], ['class' => 'glyphicon glyphicon-play-circle', 'title' => 'Посмотреть, как оператор', 'data-pjax' => 0]),
                    Html::a('', ['recipe/view', 'id' => $model->id], ['class' => 'glyphicon glyphicon-list', 'title' => 'Редактировать секции и нутриенты', 'data-pjax' => 0]),
                    Html::a('', [$model->visible ? 'recipe/hide' : 'recipe/show', 'id' => $model->id], ['class' => $model->visible ? 'glyphicon glyphicon-eye-close' : 'glyphicon glyphicon-eye-open', 'title' => $model->visible ? 'Скрыть от операторов' : 'Активировать', 'data-pjax' => 0]),
                    Html::a('', ['recipe/edit', 'id' => $model->id], ['class' => 'glyphicon glyphicon-pencil', 'title' => 'Редактировать основные поля', 'data-pjax' => 0]),
                    Html::a('', ['recipe/delete', 'id' => $model->id], ['class' => 'glyphicon glyphicon-remove', 'title' => 'Удалить рецепт', 'data-pjax' => 0])
                ]);
            }
        ]
    ],
]) ?>
