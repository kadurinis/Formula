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
?>
<div class="row" style="padding: 5px 0; font-size: 2rem">
    <div class="col-md-3"><?= $model->name ?></div>
    <div class="col-md-2"><?= date('d.m.Y', $model->created_at) ?></div>
    <div class="col-md-2"><?= $model->field ?></div>
    <div class="col-md-2"><?= $model->percent ?></div>
    <div class="col-md-3">Весы <?= Type::getList()[$type_id] ?></div>
</div>
<div class="row" style="font-size: 2rem; padding: 10px">
    <div class="col-md-12" style="margin: 15px 0">
        <?= Html::a('Завершить выполнение рецепта', ['recipe/end'], ['class' => 'btn btn-info form-control', 'style' => 'font-size: 16pt']) ?>
    </div>
</div>
<?php if ($model->visible): ?>
<?= $this->render('view', ['dataProvider' => $dataProvider]) ?>
<?php else: ?>
<div class="alert alert-warning">
    Рецепт <?= $model->name ?> закрыт администратором
</div>
<?php endif ?>
