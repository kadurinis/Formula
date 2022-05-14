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
use yii\web\View;
$this->title = 'Дополнительный экран';

?>
<?php if ($model): ?>
<div class="row" style="font-size: 2rem; padding: 10px">
    <div class="col-md-3"><?= $model->name ?></div>
    <div class="col-md-3"><?= $model->field ?></div>
    <div class="col-md-3"><?= $model->percent ?></div>
    <div class="col-md-3">Весы <?= Type::getList()[$type_id] ?> дозирования</div>
</div>
<?php $this->render('view', ['dataProvider' => $dataProvider]) ?>

<?php else: ?>
<div style="text-align: center; margin: 150pt 0">
    <h1>Ожидаем выбор рецепта на основном экране</h1>
</div>
<?php endif ?>
