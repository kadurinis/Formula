<?php
/**
 * @var \backend\models\search\RecipeModel $model
 * @var \yii\web\View $this
 */

use common\models\models\Display;
use frontend\models\models\RecipeView;
use yii\helpers\Html;

$this->title = $model->name . ': предпросмотр рецепта';
$display = Display::findModel();
$primary = new RecipeView(['recipe_id' => $model->id, 'type_id' => $display->primary_id]);
$secondary = new RecipeView(['recipe_id' => $model->id, 'type_id' => $display->secondary_id]);
?>
<div class="row" style="font-size: 2rem; padding: 10px">
    <div class="col-md-3">
        <?= Html::a(
            Html::tag('span', '', ['class' => 'glyphicon glyphicon-chevron-left']) . '&nbsp;' . 'Список рецептов',
            ['recipe/index'],
            ['class' => 'btn btn-info']
        ) ?>
    </div>
    <div class="col-md-3"><?= $model->name ?></div>
    <div class="col-md-2"><?= $model->field ?></div>
    <div class="col-md-2"><?= $model->percent ?></div>
    <div class="col-md-2"><?= date('d.m.Y', $model->getUpdatedAt()) ?></div>
</div>
<div>
    <i>* Таким рецепт видят операторы при сборке</i>
</div>
<br />
<h3>Основной экран: весы <?= strtolower($display->primary->name) ?> дозирования</h3>
<?= $this->render('@frontend/views/recipe/view', ['dataProvider' => $primary->search(), 'type_id' => $display->primary_id]) ?>
<br />
<h3>Дополнительный экран: весы <?= strtolower($display->secondary->name) ?> дозирования</h3>
<?= $this->render('@frontend/views/recipe/view', ['dataProvider' => $secondary->search(), 'type_id' => $display->secondary_id]) ?>
