<?php
/**
 * @var View $this
 * @var Recipe $model
 * @var ActiveDataProvider $dataProvider
 * @var int $type_id
 */

use common\models\models\Recipe;
use common\models\models\Type;
use frontend\assets\SecondaryAsset;
use yii\data\ActiveDataProvider;
use yii\web\View;
$this->title = 'Дополнительный экран';
SecondaryAsset::register($this);
?>
<script>let recipe_id = <?= $model && $model->visible ? $model->id : 0 ?>;</script>
<?php if ($model): ?>
    <div class="row" style="padding: 5px 0; font-size: 2rem">
        <div class="col-md-3"><?= $model->name ?></div>
        <div class="col-md-2"><?= date('d.m.Y', $model->created_at) ?></div>
        <div class="col-md-2"><?= $model->field ?></div>
        <div class="col-md-2"><?= $model->percent ?></div>
        <div class="col-md-3">Весы <?= Type::getList()[$type_id] ?></div>
    </div>
    <?php if ($model->visible): ?>
    <?= $this->render('view', ['dataProvider' => $dataProvider]) ?>
    <?php else: ?>
        <div class="alert alert-warning">
            Рецепт <?= $model->name ?> закрыт администратором
        </div>
    <?php endif ?>

<?php else: ?>
<div style="text-align: center; margin: 150pt 0">
    <h1>Ожидаем выбор рецепта на основном экране</h1>
</div>
<?php endif ?>
