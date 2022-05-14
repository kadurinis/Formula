<?php
/**
 * @var Section $section
 * @var Nutrient $exists
 * @var Nutrient $nutrients
 */

use app\models\models\Nutrient;
use app\models\models\Section;
use yii\data\ArrayDataProvider;
use kartik\grid\GridView;
use yii\helpers\Html;

?>
<h3><?= $section->name ?></h3>
<div class="row">
    <div class="col-md-6">
        <span class="fa fa-minus"></span>
        <?= GridView::widget([
            'dataProvider' => new ArrayDataProvider(['allModels' => $exists]),
            'layout' => '{items}',
            'showHeader' => false,
            'columns' => [
                'name',
                [
                    'format' => 'html',
                    'value' => static function (Nutrient $model) use ($section) {
                        return Html::a('x', ['admin/delete-section-nutrient', 'section_id' => $section->id, 'nutrient_id' => $model->id], ['class' => 'btn btn-danger']);
                    }
                ]
            ]
        ]) ?>
    </div>
    <div class="col-md-6">
        <?= GridView::widget([
            'dataProvider' => new ArrayDataProvider(['allModels' => $nutrients]),
            'layout' => '{items}',
            'showHeader' => false,
            'columns' => [
                'name',
                [
                    'format' => 'html',
                    'value' => static function (Nutrient $model) use ($section) {
                        return Html::a('+', ['admin/add-section-nutrient', 'section_id' => $section->id, 'nutrient_id' => $model->id], ['class' => 'btn btn-primary']);
                    }
                ]
            ]
        ]) ?>
    </div>
</div>
