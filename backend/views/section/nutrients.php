<?php
/**
 * @var View $this
 * @var ActiveDataProvider $dataProvider
 * @var ActiveDataProvider $availableDataProvider
 * @var SectionModel $model
 * @var NutrientModel[] $available
 * @var NutrientModel[] $bound
 */

use backend\models\search\NutrientModel;
use backend\models\search\SectionModel;
use yii\bootstrap\Html;
use yii\data\ActiveDataProvider;
use yii\web\View;

$this->title = 'Нутриенты секции: ' . $model->name;
?>
<style>
    #relationship .btn {margin: 4px}
</style>
<?= Yii::$app->session->getFlash('error') ?>
<div class="row" id="relationship">
    <div class="col-md-1"></div>
    <div class="col-md-4">
        <h3>Прикрепленные</h3>
        <sup>Нажми, чтобы удалить</sup>
        <?php
            foreach ($bound as $item) {
                $class = 'btn form-control btn-success';
                $title = '';
                if ($item->type_id !== $model->type_id) {
                    $class = 'btn form-control btn-warning';
                    $title = 'Типы у секции и нутриента отличаются. Вероятно, нутриент больше не подходит этой секции';
                }
                if (!$item->isAlive()) {
                    $class = 'btn form-control btn-danger';
                    $title = 'Нутриент удален из справочника';
                }
                echo Html::a(
                    Html::tag('span', '', ['class' => 'fa fa-minus']) . '&nbsp' . $item->name,
                    ['section/release-nutrient', 'SectionNutrientModel[section_id]' => $model->id, 'SectionNutrientModel[nutrient_id]' => $item->id],
                    ['class' => $class, 'title' => $title]
                );
            } ?>
    </div>
    <div class="col-md-2"></div>
    <div class="col-md-4">
        <h3>Доступные</h3>
        <sup>Нажми, чтобы добавить</sup>
        <?php foreach ($available as $item) : ?>
            <?= Html::a(
                Html::tag('span', '', ['class' => 'fa fa-plus']) . '&nbsp' . $item->name,
                ['section/bind-nutrient', 'SectionNutrientModel[section_id]' => $model->id, 'SectionNutrientModel[nutrient_id]' => $item->id],
                ['class' => 'btn btn-info form-control']
            ) ?>
        <?php endforeach ?>
    </div>
    <div class="col-md-1"></div>
</div>

