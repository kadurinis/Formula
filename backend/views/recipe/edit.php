<?php

use backend\models\search\RecipeModel;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var RecipeModel $model
 */
$is_new = $model->isNewRecord;
$this->title = $is_new ? 'Добавление рецепта' : $model->name . ': редактирование полей';
?>

<?php $form = ActiveForm::begin(['method' => 'post']) ?>
<?= $form->field($model, 'name')->textInput(['placeholder' => 'Например, ПС-7']) ?>
<?= $form->field($model, 'field')->textInput(['placeholder' => 'Например, 22.5т']) ?>
<?= $form->field($model, 'percent')->textInput(['placeholder' => 'Например, 0.48%']) ?>
<?= Html::submitButton($is_new ? 'Добавить' : 'Сохранить', ['class' => 'btn btn-info form-control']) ?>
<?php ActiveForm::end() ?>


