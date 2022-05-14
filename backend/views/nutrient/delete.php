<?php
/**
 * @var NutrientModel $model
 * @var SectionNutrient[]|RecipeNutrient[] $usage
 */

use backend\models\search\NutrientModel;
use common\models\relations\RecipeNutrient;
use common\models\relations\SectionNutrient;
use yii\helpers\Html;

$this->title = 'Удаление нутриента ' . ($model ? $model->name : '');
?>

<?php if ($model) :?>
    <?php if ($usage): ?>
    <div class="row">
        <div class="col-md-6">
            <div class="alert alert-warning">
                Нутриент <?= $model->name ?> соотнесен с секциями и рецептами. Ниже список.
                Чтобы свести к нулю возможность отображения некорректного рецепта, следует самостоятельно внести коррективы в каждом из них.
                <?php if ($model->isAlive()) : ?>
                    <br /><br />Если ты действительно хочешь удалить нутриент, нажми кнопку удалить. Страница перезагрузится и ты сможешь последовательно пройти по списку и удалить соотношения.
                <?php else: ?>
                    <br /><br />Нутриент удален
                <?php endif ?>
            </div>
        </div>
        <div class="col-md-6">
            <ol><b>Отсылки:</b>
                <?php foreach ($usage as $item) : ?>
                    <?php if (is_a($item, SectionNutrient::class)) : ?>
                        <li>Секция <?= Html::a($item->section->name, ['section/index', 'SectionModel[id]' => $item->section_id]) ?></li>
                    <?php endif ?>
                    <?php if (is_a($item, RecipeNutrient::class)) : ?>
                        <li>Рецепт <?= Html::a($item->recipe->name, ['recipe/index', 'RecipeModel[id]' => $item->recipe_id]) ?></li>
                    <?php endif ?>
                <?php endforeach; ?>
            </ol>
        </div>
    </div>

    <?php else: ?>
    <div class="alert alert-success">
        <?= Html::tag('span', '', ['class' => 'glyphicon glyphicon-ok']) ?> Нутриент не имеет активных ссылок на секции и рецепты
    </div>
    <?php endif ?>

    <?php if ($model->isAlive()) : ?>
        <?= Html::a('Удалить', ['nutrient/delete', 'id' => $model->id, 'confirm' => 'yes'], ['class' => 'btn btn-primary form-control']) ?>
    <?php endif ?>

<?php else : ?>
<div class="alert alert-danger">
    Нутриент не найден
</div>
<?php endif ?>


