<?php

use backend\assets\RecipeAsset;
use backend\models\search\RecipeActiveRow;
use backend\models\search\RecipeModel;
use common\models\models\Type;
use kartik\grid\DataColumn;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\bootstrap\Html;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;

/**
 * @var RecipeModel $model
 * @var RecipeActiveRow[] $models indexed by type_id
 * @var ActiveDataProvider $dataProvider
 * @var array $warnings
 */
$this->title = $model->name . ': редактор компонентов';
RecipeAsset::register($this);
$types = Type::getList();
$this->registerCss('.kv-page-summary td:last-child {display: none}');
?>
<div class="row" style="font-size: 2rem; padding: 10px">
    <div class="col-md-6" style="white-space: nowrap">
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
    <div class="col-md-6" style="text-align: right">
        <?= $model->name ?> &nbsp;
        <?= date('d.m.Y', $model->getUpdatedAt()) ?> &nbsp;
        <?= $model->field ?> &nbsp;
        <?= $model->percent ?><br />
        <div style="font-size: 14pt">
            Итого: <span id="total-weight">0</span> г
        </div>
    </div>
</div>
<div id="recipe-edit" style="max-height: 100vh; overflow-y: scroll">
<?= Html::hiddenInput('recipe_id', $model->id) ?>

<?php foreach ($models as $id => $list) : ?>
<h3><?= $types[$id] ?></h3>
<?= GridView::widget([
    'dataProvider' => new ArrayDataProvider(['allModels' => $list, 'pagination' => ['pageSize' => 100]]),
    'resizableColumns' => false,
    'striped' => false,
    'hover' => true,
    'showPageSummary' => true,
    'pjax' => true,
    'pjaxSettings' => [
        'options' => ['id' => 'recipe-pjax-' . $id],
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
        [
            'class' => SerialColumn::class,
            'width' => '3%',
        ],
        [
            'attribute' => 'section.name',
            'header' => 'Секция',
            'format' => 'text',
            'group' => true,
            'headerOptions' => ['style' => 'width: 18%'],
            'groupFooter' => function (RecipeActiveRow $model, $key, $index, $widget) { // Closure method
                return [
                    'mergeColumns' => [[1,2]], // columns to merge in summary
                    'content' => [             // content to show in each summary cell
                        1 => '<span style="float:right">Итого</span>',
                        3 => GridView::F_SUM,
                    ],
                    'contentFormats' => [      // content reformatting for each summary cell
                        3 => ['format'=>'number', 'decimals'=>2, 'decPoint'=>'.', 'thousandSep'=>' '],
                    ],
                    'contentOptions' => [      // content html attributes for each summary cell
                        1 => ['style' => 'font-variant:small-caps'],
                        3 => ['style' => 'text-align:right'],
                        4 => ['style' => 'display: none'],
                    ],
                    // html attributes for group summary row
                    'options' => ['class' => 'info table-info','style' => 'font-weight:bold;']
                ];
            }
        ],
        [
            'attribute' => 'nutrient.name',
            'header' => 'Нутриент',
            'format' => 'text',
            'headerOptions' => ['style' => 'width: 28%'],
            'pageSummary' => 'Итого',
            'pageSummaryOptions' => ['class' => 'text-right text-end'],
        ],
        [
            'attribute' => 'weight',
            'contentOptions' => ['style' => 'display:none', 'class' => 'weight-number'],
            'headerOptions' => ['style' => 'display:none'],
            'pageSummary' => true,
            'pageSummaryFunc' => GridView::F_SUM
        ],
        [
            'class' => DataColumn::class,
            'header' => 'Вес, г',
            'format' => 'raw',
            'headerOptions' => ['style' => 'width: 23%'],
            'value' => static function (RecipeActiveRow $model, $key, $index, $context) {
                return Html::textInput('weight-value', $model->weight, ['class' => 'form-control', 'placeholder' => 0, 'data-id' => "weight-{$model->section_id}-{$model->nutrient_id}"]);
            }
        ],
        [
            'attribute' => 'comment',
            'format' => 'raw',
            'headerOptions' => ['style' => 'width: 23%'],
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
<?php endforeach ?>
</div>