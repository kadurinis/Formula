<?php

use common\models\models\Display;
use yii\helpers\Html;
$model = Display::findModel();
$primary = $model->primary->name;
$secondary = $model->secondary->name;
$this->title = 'Выбор экрана';
?>
<div class="row" style="text-align: center; margin: 150pt 0">
    <div class="col-md-6">
        <?= Html::a('Основной экран', ['recipe/primary'], ['class' => 'btn btn-primary form-control']) ?>
    </div>
    <div class="col-md-6">
        <?= Html::a('Дополнительный экран', ['recipe/secondary'], ['class' => 'btn btn-primary form-control']) ?>
    </div>
</div>
