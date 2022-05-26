<?php
/**
 * @var View $this
 * @var ActiveDataProvider $dataProvider
 * @var SectionModel $model
 * @var array $warnings
 */

use backend\models\search\SectionModel;
use backend\models\search\TypeModel;
use common\models\models\Type;
use kartik\grid\DataColumn;
use kartik\grid\ExpandRowColumn;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use kartik\select2\Select2;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\web\View;

$this->title = 'Секции';
$types = Type::getList();
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $model,
    'resizableColumns' => false,
    'hover' => true,
    'layout' => '{items}',
    'pjax' => true,
    'pjaxSettings' => [
        'options' => ['id' => 'section-pjax'],
    ],
    'rowOptions' => static function (SectionModel $model) use ($warnings) {
        return isset($warnings[$model->id]) ? ['class' => 'danger', 'title' => $warnings[$model->id]] : [];
    },
    'columns' => [
        ['class' => SerialColumn::class],
        'name:text',
        [
            'class' => DataColumn::class,
            'attribute' => 'type_id',
            'filter' => TypeModel::getList(),
            'filterType' => GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'theme' => Select2::THEME_DEFAULT,
                'pluginOptions' => [
                    'placeholder' => '',
                    'allowClear' => true,
                    'dropdownAutoWidth' => true,
                ]
            ],
            'value' => static function (SectionModel $model) {
                return $model->type->name;
            },
            'group' => true,
        ],
        ['attribute' => 'created_at', 'format' => ['datetime', 'php:d.m.Y H:i:s'], 'filter' => false],
        [
            'header' => Html::a('', ['section/edit'], ['class' => 'btn btn-success glyphicon glyphicon-plus', 'title' => 'Добавить секцию', 'data-pjax' => 0]),
            'width' => '3%',
            'format' => 'raw',
            'contentOptions' => ['style' => 'white-space: nowrap'],
            'value' => static function (SectionModel $model) {
                return implode('&nbsp;', [
                    Html::a('', ['section/nutrients', 'id' => $model->id], ['class' => 'glyphicon glyphicon-list', 'data-pjax' => 0]),
                    Html::a('', ['section/edit', 'id' => $model->id], ['class' => 'glyphicon glyphicon-pencil', 'data-pjax' => 0]),
                    Html::a('', ['section/delete', 'id' => $model->id], ['class' => 'glyphicon glyphicon-remove', 'data-pjax' => 0])
                ]);
            }
        ],
        [
            'class' => ExpandRowColumn::class,
            'width' => '30px',
            'contentOptions' => ['style' => 'padding: 5px'],
            'value' => static function () {
                return GridView::ROW_COLLAPSED;
            },
            'detailRowCssClass' => GridView::TYPE_DEFAULT,
            'expandIcon' => Html::tag('span', '', ['class' => 'glyphicon glyphicon-chevron-right']),
            'collapseIcon' => Html::tag('span', '', ['class' => 'glyphicon glyphicon-chevron-down']),
            'detailAnimationDuration' => 'fast',
            'detail' => static function (SectionModel $model) {
                return GridView::widget([
                    'dataProvider' => new ArrayDataProvider(['allModels' => $model->nutrients]),
                    'layout' => '{items}',
                    'showHeader' => false,
                    'columns' => [
                        'name:text',
                    ],
                ]);
            },
        ],
    ],
]) ?>