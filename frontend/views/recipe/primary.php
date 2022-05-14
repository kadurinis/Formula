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

?>
<div class="row" style="font-size: 2rem; padding: 10px">
    <div class="col-md-12" style="margin: 15px 0">
        <?= Html::a('Завершить выполнение рецепта', ['recipe/end'], ['class' => 'btn btn-info form-control', 'style' => 'font-size: 16pt']) ?>
    </div>
    <div class="col-md-3"><?= $model->name ?></div>
    <div class="col-md-3"><?= $model->field ?></div>
    <div class="col-md-3"><?= $model->percent ?></div>
    <div class="col-md-3">Весы <?= Type::getList()[$type_id] ?> дозирования</div>
</div>
<?= $this->render('view', ['dataProvider' => $dataProvider]) ?>
