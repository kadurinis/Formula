<?php
/**
 * @var \yii\web\View $this
 * @var Type $type
 * @var Nutrient $nutrient
 * @var Section $section
 */

use app\models\models\Nutrient;
use app\models\models\Section;
use app\models\models\Type;
use yii\bootstrap4\Html;
use yii\widgets\ActiveForm;

?>
<div class="row">
    <?php \Yii::$app->session->getFlash('success') ?>
    <?php \Yii::$app->session->getFlash('error') ?>
</div>
<div class="row" style="min-height: 50vh">
    <div class="col-md-4">
        <h3>Типы</h3>
        <?= \yii\grid\GridView::widget([
            'dataProvider' => $type->search(),
            'layout' => '{items}',
            'columns' => [
                'name:text',
                [
                    'format' => 'raw',
                    'value' => static function (Type $model) {
                        return Html::a(
                            '-',
                            ['admin/delete-from-list', 'model' => $model::className(), 'id' => $model->id],
                            ['title' => 'Удалить', 'onClick' => 'if (!confirm("Удалить нутриент?")) return false;']
                        );
                    }
                ],
            ]
        ]) ?>
    </div>
    <div class="col-md-4">
        <h3>Секции</h3>
        <?= \yii\grid\GridView::widget([
            'dataProvider' => $section->search(),
            'layout' => '{items}',
            'columns' => [
                'name:text',
                'type.name:text',
                [
                    'format' => 'raw',
                    'value' => static function (Section $model) {
                        return Html::a(
                            '-',
                            ['admin/delete-from-list', 'model' => $model::className(), 'id' => $model->id],
                            ['title' => 'Удалить', 'onClick' => 'if (!confirm("Удалить?")) return false;']
                        );
                    }
                ],
            ]
        ]) ?>
    </div>
    <div class="col-md-4">
        <h3>Нутриенты</h3>
        <?= \yii\grid\GridView::widget([
            'dataProvider' => $nutrient->search(),
            'layout' => '{items}',
            'columns' => [
                'name:text',
                'type.name:text',
                [
                    'format' => 'raw',
                    'value' => static function (Nutrient $model) {
                        return Html::a(
                            '-',
                            ['admin/delete-from-list', 'model' => $model::className(), 'id' => $model->id],
                            ['title' => 'Удалить', 'onClick' => 'if (!confirm("Удалить нутриент?")) return false;']
                        );
                    }
                ],
            ]
        ]) ?>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <?php $form = ActiveForm::begin(['action' => ['admin/add-type'], 'method' => 'post']) ?>
        <?= $form->field($type, 'name') ?>
        <div class="form-group">
            <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end() ?>
    </div>
    <div class="col-md-4">
        <?php $form = ActiveForm::begin(['action' => ['admin/add-section'], 'method' => 'post']) ?>
        <?= $form->field($section, 'name') ?>
        <?= $form->field($section, 'type_id')->dropDownList($type::getList()) ?>
        <div class="form-group">
            <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end() ?>
    </div>
    <div class="col-md-4">
        <?php $form = ActiveForm::begin(['action' => ['admin/add-nutrient', 'method' => 'post']]) ?>
        <?= $form->field($nutrient, 'name') ?>
        <?= $form->field($nutrient, 'type_id')->dropDownList($type::getList()) ?>
        <div class="form-group">
            <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end() ?>
    </div>

</div>