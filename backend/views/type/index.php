<?php
/**
 * @var ActiveDataProvider $dataProvider
 * @var TypeModel $model
 */

use backend\models\search\TypeModel;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;

$this->title = 'Типы';
?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $model,
    'resizableColumns' => false,
    'layout' => '{items}',
    'pjax' => true,
    'pjaxSettings' => [
        'options' => ['id' => 'types-pjax'],
    ],
    'columns' => [
        ['class' => SerialColumn::class],
        'name:text',
        'created_at:datetime',
        [
            'header' => 'Секции',
            'format' => 'raw',
            'value' => static function (TypeModel $model) {
                return Html::a(count($model->sections), ['section/index'], ['title' => 'Секций такого типа', 'data-pjax' => 0]);
            }
        ],
        [
            'header' => 'Нутриенты',
            'format' => 'raw',
            'value' => static function (TypeModel $model) {
                return Html::a(count($model->nutrients), ['nutrient/index', 'NutrientModel[type_id]' => $model->id], ['title' => 'Нутриентов такого типа', 'data-pjax' => 0]);
            }
        ],
        [
            'header' => '',
            'format' => 'raw',
            'value' => static function (TypeModel $model) {
                return implode('&nbsp;', [
                    Html::a('', ['nutrient/edit', 'id' => $model->id], ['class' => 'glyphicon glyphicon-pencil', 'data-pjax' => 0]),
                    Html::a('', ['nutrient/delete', 'id' => $model->id], ['class' => 'glyphicon glyphicon-remove', 'data-pjax' => 0])
                ]);
            }
        ],
    ],
]) ?>

