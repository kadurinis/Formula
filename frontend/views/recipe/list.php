<?php
/**
 * @var \yii\web\View $this
 */

use yii\helpers\Html;

/**
 * @var array $list
 */
$this->registerCss('a.item {min-width: 10em; padding: 20px 5px; margin: 5px 5px; font-size: 1.5rem; width:22%;}');
$this->title = 'Основной экран';
?>
<div style="display: flex; flex-flow: row wrap; justify-content: space-around; align-content: flex-start; margin-top: 25px">
    <?php foreach ($list as $id => $name) : ?>
    <?= Html::a($name, ['recipe/begin', 'id' => $id], ['class' => 'btn btn-info item']) ?>
    <?php endforeach; ?>
</div>
