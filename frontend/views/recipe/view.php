<?php

use common\models\models\Display;
use frontend\models\models\RecipeView;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\helpers\Html;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \yii\web\View $this
 */
$this->registerCss(Display::getFontCss());
?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'resizableColumns' => false,
    'striped' => false,
    'hover' => true,
    'showPageSummary' => true,
    'pjax' => true,
    'pjaxSettings' => [
        'options' => ['id' => 'recipe-pjax'],
    ],
    'layout' => '{items}',
    'columns' => [
        [
            'attribute' => 'section.name',
            'format' => 'text',
            'header' => 'Секция',
            'group' => true,
            'groupFooter' => static function (RecipeView $model, $key, $index, $widget) { // Closure method
                return [
                    //'mergeColumns' => [[1,2]], // columns to merge in summary
                    'content' => [             // content to show in each summary cell
                        1 => '<span style="float:right">Итого</span>',
                        2 => GridView::F_SUM,
                    ],
                    'contentFormats' => [      // content reformatting for each summary cell
                        2 => ['format' => 'number', 'decimals' => 0],
                    ],
                    'contentOptions' => [      // content html attributes for each summary cell
                        1 => ['style' => 'font-variant:small-caps'],
                    ],
                    // html attributes for group summary row
                    'options' => ['class' => 'info table-info','style' => 'font-weight:bold;']
                ];
            }
        ],
        [
            'attribute' => 'nutrient.name',
            'format' => 'html',
            'header' => 'Нутриент',
            'pageSummary' => 'Итого',
            'pageSummaryOptions' => ['class' => 'text-right text-end'],
            'value' => static function ($model) {
                return $model->comment
                    ? implode('', [
                        Html::tag('div', $model->nutrient->name),
                        Html::tag('div', $model->comment, ['style' => 'font-size: 1rem']),
                    ])
                    : $model->nutrient->name;
            }
        ],
        [
            'attribute' => 'weight',
            'format' => 'text',
            'header' => 'Вес',
            'pageSummary' => true,
            'pageSummaryFunc' => GridView::F_SUM
        ],
    ],
]) ?>
