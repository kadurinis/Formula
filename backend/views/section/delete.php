<?php
/**
 * @var SectionModel $model
 * @var SectionNutrient[]|RecipeNutrient[] $usage
 */

use backend\models\search\SectionModel;
use common\models\models\Recipe;
use common\models\relations\RecipeNutrient;
use common\models\relations\SectionNutrient;
use yii\helpers\Html;

$this->title = 'Удаление секции ' . ($model ? $model->name : '');
?>

<?php if ($model) :?>
    <?php if ($usage): ?>
        <div class="row">
            <div class="col-md-6">
                <div class="alert alert-warning">
                    Секция <?= $model->name ?> используется с рецептами. Ниже список.
                    Чтобы свести к нулю возможность отображения некорректного рецепта, следует самостоятельно внести коррективы в каждом из них.
                    <?php if ($model->isAlive()) : ?>
                        <br /><br />Если ты действительно хочешь удалить секцию, нажми кнопку удалить. Страница перезагрузится и ты сможешь последовательно пройти по списку и удалить соотношения.
                    <?php else: ?>
                        <br /><br />Секция удалена
                    <?php endif ?>
                </div>
            </div>
            <div class="col-md-6">
                <ol><b>Отсылки:</b>
                    <?php foreach ($usage as $item) : ?>

                            <li>Рецепт <?= Html::a($item->name, ['recipe/index', 'RecipeModel[id]' => $item->id]) ?></li>

                    <?php endforeach; ?>
                </ol>
            </div>
        </div>

    <?php else: ?>
        <div class="alert alert-success">
            <?= Html::tag('span', '', ['class' => 'glyphicon glyphicon-ok']) ?> На эту секцию не ссылается ни один активный рецепт
        </div>
    <?php endif ?>

    <?php if ($model->isAlive()) : ?>
        <?= Html::a('Удалить', ['section/delete', 'id' => $model->id, 'confirm' => 'yes'], ['class' => 'btn btn-primary form-control']) ?>
    <?php endif ?>

<?php else : ?>
    <div class="alert alert-danger">
        Секция не найдена
    </div>
<?php endif ?>


