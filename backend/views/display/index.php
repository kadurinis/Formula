<?php

use common\models\models\Display;
use common\models\models\Type;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var Display $model
 */
$this->title = 'Настройки отображения';
?>
<div>
    <?php $form = ActiveForm::begin(['method' => 'post']) ?>
    <div class="col-md-4">
        <?= $form->field($model, 'primary_id')->dropDownList(Type::getList(), ['class' => 'form-control']) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'secondary_id')->dropDownList(Type::getList(), ['class' => 'form-control']) ?>
    </div>
    <div class="col-md-4">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end() ?>
</div>
