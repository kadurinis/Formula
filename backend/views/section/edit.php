<?php

use backend\models\search\NutrientModel;
use backend\models\search\TypeModel;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var NutrientModel $model
 */
$is_new = $model->isNewRecord;
$can_type = $is_new && !$model->findUsage();
$this->title = $is_new ? 'Добавление секции' : 'Редактирование ' . $model->name;
?>
<?php if (!$can_type) : ?>
    <div class="alert alert-warning">
        Тип отредактировать нельзя. Если ошибся, просто удали нутриент и создай заново
    </div>
<?php endif ?>

<?php $form = ActiveForm::begin(['method' => 'post']) ?>
<?= $form->field($model, 'name') ?>
<?= $form->field($model, 'type_id')->dropDownList(TypeModel::getList(), ['disabled' => !$can_type]) ?>
<?= Html::submitButton($is_new ? 'Добавить' : 'Сохранить', ['class' => 'btn btn-info form-control']) ?>
<?php ActiveForm::end() ?>


