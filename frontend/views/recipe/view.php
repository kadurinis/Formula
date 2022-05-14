<?php

use frontend\models\models\RecipeView;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 */
?>
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
    'columns' => [
        ['class' => SerialColumn::class],
        [
            'attribute' => 'section.name',
            'format' => 'text',
            'header' => 'Секция',
            'group' => true,
            'groupFooter' => static function (RecipeView $model, $key, $index, $widget) { // Closure method
                return [
                    'mergeColumns' => [[1,2]], // columns to merge in summary
                    'content' => [             // content to show in each summary cell
                        1 => '<span style="float:right">Итого</span>',
                        3 => GridView::F_SUM,
                    ],
                    'contentFormats' => [      // content reformatting for each summary cell
                        3 => ['format' => 'number', 'decimals' => 2],
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
            'format' => 'text',
            'header' => 'Нутриент',
        ],
        [
            'attribute' => 'weight',
            'format' => 'text',
            'header' => 'Вес',
        ],
    ],
]) ?>
