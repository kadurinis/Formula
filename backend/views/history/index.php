<?php

use backend\models\search\HistoryModel;
use backend\models\search\RecipeModel;
use kartik\grid\DataColumn;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use kartik\select2\Select2;
use yii\data\ActiveDataProvider;
/**
 * @var HistoryModel $model
 * @var ActiveDataProvider $dataProvider
 */
$this->title = 'История выполнения';
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $model,
    'resizableColumns' => false,
    'pjax' => true,
    'pjaxSettings' => [
        'options' => ['id' => 'history-pjax'],
    ],
    'columns' => [
        ['class' => SerialColumn::class],
        [
            'class' => DataColumn::class,
            'attribute' => 'recipe_id',
            'filter' => RecipeModel::getList(),
            'filterType' => GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'theme' => Select2::THEME_DEFAULT,
                'pluginOptions' => [
                    'placeholder' => '',
                    'allowClear' => true,
                    'dropdownAutoWidth' => true,
                ]
            ],
            'value' => static function (HistoryModel $model) {
                return $model->recipe->name;
            }
        ],
        'started:datetime',
        'finished:datetime',
    ],
]) ?>
