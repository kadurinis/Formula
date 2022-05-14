<?php
/**
 * @var RecipeModel $model
 * @var \yii\web\View $this
 */

use backend\models\search\RecipeModel;
use yii\helpers\Html;

$this->title = 'Удаление рецепта ' . ($model ? $model->name : '');
?>

<?php if ($model) :?>
    <?php if ($model->isAlive()) : ?>
        <div class="alert alert-warning">
            Удаление рецепта означает, что все его связи с секциями и нутриентами будут удалены. Если нужно просто закрыть рецепт от пользователей, используй кнопку "скрыть" в списке рецептов.
        </div>
        <?= Html::a('Удалить', ['recipe/delete', 'id' => $model->id, 'confirm' => 'yes'], ['class' => 'btn btn-primary form-control']) ?>
    <?php else: ?>
        <div class="alert alert-success">
            Рецепт удален
        </div>
    <?php endif ?>
<?php else : ?>
    <div class="alert alert-danger">
        Рецепт не найден
    </div>
<?php endif ?>


