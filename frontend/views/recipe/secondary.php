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
$type = mb_strtolower(Type::getList()[$type_id]);
?>
<script>let recipe_id = <?= $model && $model->visible ? $model->id : 0 ?>;</script>
<?php if ($model): ?>
    <div class="row" style="padding: 5px 0; font-size: 2rem">
        <div class="col-md-4">
            <div><?= $model->name ?></div>
            <div><?= date('d.m.Y', $model->getUpdatedAt()) ?></div>
        </div>
        <div class="col-md-2">
            <div><?= $model->field ?></div>
            <div><?= $model->percent ?></div>
        </div>
        <div class="col-md-6" style="text-align: right">Весы <?= $type ?> дозирования</div>
    </div>
    <?php if ($model->visible): ?>
    <?= $this->render('view', ['dataProvider' => $dataProvider, 'type_id' => $type_id, 'total_weight' => null]) ?>
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
