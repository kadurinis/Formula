<?php
/**
 * @var \yii\web\View $this
 */

use yii\helpers\Html;

/**
 * @var array $list
 */
$this->registerCss('.item {min-width: 10em; margin: 10px 5px}');
?>
<div style="display: flex; flex-flow: row wrap; justify-content: space-around; align-content: flex-start">
    <?php foreach ($list as $id => $name) : ?>
    <?= Html::a($name, ['recipe/begin', 'id' => $id], ['class' => 'btn btn-info item']) ?>
    <?php endforeach; ?>
</div>
