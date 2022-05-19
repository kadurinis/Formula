<?php
/**
 * @var View $this
 * @var Recipe $model
 * @var ActiveDataProvider $dataProvider
 * @var int $type_id
 */

use common\models\models\Recipe;
use common\models\models\Type;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;

$this->title = 'Основной экран';
$type = mb_strtolower(Type::getList()[$type_id]);
$total_weight =$model->getTotalWeight();
?>
<div class="row" style="padding: 5px 0; font-size: 2rem">
    <div class="col-md-4">
        <div><?= $model->name ?></div>
        <div><?= date('d.m.Y', $model->created_at) ?></div>
    </div>
    <div class="col-md-2">
        <div><?= $model->field ?></div>
        <div><?= $model->percent ?></div>
    </div>
    <div class="col-md-6" style="text-align: right">
        <div>Весы <?= $type ?> дозирования</div>
    </div>
</div>
<div class="row" style="font-size: 2rem;">
    <div class="col-md-12" style="margin: 15px 0">
        <?= Html::a('Завершить выполнение рецепта', ['recipe/end'], ['class' => 'btn btn-info form-control', 'style' => 'font-size: 16pt']) ?>
    </div>
</div>
<?php if ($model->visible): ?>
<?= $this->render('view', ['dataProvider' => $dataProvider, 'type_id' => $type_id, 'total_weight' => $total_weight]) ?>
<?php else: ?>
<div class="alert alert-warning">
    Рецепт <?= $model->name ?> закрыт администратором
</div>
<?php endif ?>
