<?php

use common\models\models\Display;
use common\models\models\Type;
use frontend\models\models\RecipeView;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\helpers\Html;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \yii\web\View $this
 * @var int $type_id
 * @var int $total_weight
 */
$this->registerCss(Display::getFontCss());
$type = Type::getName($type_id, '');
Yii::$app->formatter->thousandSeparator = ' ';
?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'resizableColumns' => false,
    'striped' => true,
    'hover' => true,
    'showPageSummary' => true,
    'pjax' => true,
    'pjaxSettings' => [
        'options' => ['id' => 'recipe-pjax'],
    ],
    'layout' => '{items}',
    'formatter' => [
        'class' => 'yii\i18n\Formatter',
        'thousandSeparator' => ' ',
        'decimalSeparator' => '.'
    ],
    'columns' => [
        [
            'class' => \kartik\grid\DataColumn::class,
            'attribute' => 'section.name',
            'format' => 'text',
            'header' => 'Секция',
            'group' => true,
            'groupFooter' => static function (RecipeView $model, $key, $index, $widget) { // Closure method
                return [
                    //'mergeColumns' => [[1,2]], // columns to merge in summary
                    'content' => [             // content to show in each summary cell
                        1 => Html::tag('span', "Итого", ['style' => 'float: right']),
                        2 => GridView::F_SUM,
                    ],
                    'contentFormats' => [      // content reformatting for each summary cell
                        2 => ['format'=>'number', 'decimals'=>2, 'decPoint'=>'.', 'thousandSep'=>' ']
                    ],
                    'contentOptions' => [      // content html attributes for each summary cell
                        1 => ['style' => 'font-variant:small-caps'],
                    ],
                    // html attributes for group summary row
                    'options' => ['class' => 'info table-info']
                ];
            }
        ],
        [
            'attribute' => 'nutrient.name',
            'format' => 'html',
            'header' => 'Нутриент',
            'pageSummary' => 'Всего',
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
            'format' => ['decimal', 2],
            'header' => 'Вес, г',
            'pageSummary' => true,
            'pageSummaryFunc' => GridView::F_SUM
        ],
    ],
]) ?>
<?php if (isset($total_weight)) : ?>
    <div style="text-align: right; font-weight: bold">
        Общий вес рецепта, г: <?= Yii::$app->formatter->format($total_weight, ['decimal', 'decimals'=>2, 'decPoint'=>'.', 'thousandSeparator'=>' ']) ?>
    </div>
<?php endif ?>