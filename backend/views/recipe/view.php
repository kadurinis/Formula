<?php

use backend\assets\RecipeAsset;
use backend\models\search\RecipeActiveRow;
use backend\models\search\RecipeModel;
use kartik\grid\DataColumn;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\bootstrap\Html;
use yii\data\ActiveDataProvider;
/**
 * @var RecipeModel $model
 * @var ActiveDataProvider $dataProvider
 * @var array $warnings
 */
$this->title = $model->name;
$this->params['hideTitle'] = true;
RecipeAsset::register($this);
?>
<div class="row" style="font-size: 2rem; padding: 10px">
    <div class="col-md-3">
        <?= Html::a(
                Html::tag('span', '', ['class' => 'glyphicon glyphicon-chevron-left']) . '&nbsp;' . 'Список рецептов',
                ['recipe/index'],
                ['class' => 'btn btn-info']
        ) ?>
        <?= Html::a(
                'Редактировать',
                ['recipe/edit', 'id' => $model->id],
                ['class' => 'btn btn-primary']
        ) ?>
    </div>
    <div class="col-md-3"><?= $model->name ?></div>
    <div class="col-md-3"><?= $model->field ?></div>
    <div class="col-md-3"><?= $model->percent ?></div>
</div>
<div id="recipe-edit">
<?= Html::hiddenInput('recipe_id', $model->id) ?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'resizableColumns' => false,
    'striped' => false,
    'hover' => true,
    'pjax' => true,
    'pjaxSettings' => [
        'options' => ['id' => 'recipe-pjax'],
    ],
    'layout' => '{items}',
    'rowOptions' => static function (RecipeActiveRow $model) use ($warnings) {
        return array_merge(
                ['section_id' => $model->section_id, 'nutrient_id' => $model->nutrient_id],
                $model->isSelected() ? ['class' => 'success'] : [],
            isset($warnings[$model->id]) ? ['class' => 'danger', 'title' => $warnings[$model->id]] : []
        );
    },
    'columns' => [
        ['class' => SerialColumn::class],
        [
            'attribute' => 'section.name',
            'format' => 'text',
            'group' => true,
            'groupFooter' => function (RecipeActiveRow $model, $key, $index, $widget) { // Closure method
                return [
                    'mergeColumns' => [[1,3]], // columns to merge in summary
                    'content' => [             // content to show in each summary cell
                        1 => '<span style="float:right">Итого</span>',
                        4 => GridView::F_SUM,
                    ],
                    'contentFormats' => [      // content reformatting for each summary cell
                        4 => ['format' => 'number', 'decimals' => 2],
                    ],
                    'contentOptions' => [      // content html attributes for each summary cell
                        1 => ['style' => 'font-variant:small-caps'],
                        4 => ['style' => 'text-align:right'],
                        5 => ['style' => 'display: none'],
                    ],
                    // html attributes for group summary row
                    'options' => ['class' => 'info table-info','style' => 'font-weight:bold;']
                ];
            }
        ],
        [
            'attribute' => 'section.type.name',
            'group' => true,
        ],
        'nutrient.name:text',
        [
            'attribute' => 'weight',
            'contentOptions' => ['style' => 'display:none'],
            'headerOptions' => ['style' => 'display:none'],
        ],
        [
            'class' => DataColumn::class,
            'header' => 'Вес',
            'format' => 'raw',
            'value' => static function (RecipeActiveRow $model, $key, $index, $context) {
                return Html::textInput('weight-value', $model->weight, ['class' => 'form-control', 'placeholder' => 0, 'data-id' => "weight-{$model->section_id}-{$model->nutrient_id}"]);
            }
        ],
        [
            'attribute' => 'comment',
            'format' => 'raw',
            'value' => static function (RecipeActiveRow $model) {
                return Html::textInput('comment-value', $model->comment, ['class' => 'form-control', 'data-id' => "comment-{$model->section_id}-{$model->nutrient_id}", 'disabled' => !$model->id]);
            }
        ],
        [
            'header' => '',
            'format' => 'raw',
            'width' => '2%',
            'value' => static function (RecipeActiveRow $model) {
                return implode('&nbsp;', [
                    $model->isSelected() ? Html::a('', ['#'], ['class' => 'remove-row glyphicon glyphicon-remove', 'data-pjax' => 0]) : ''
                ]);
            }
        ],
    ],
]) ?>
</div>

