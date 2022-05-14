<?php
/**
 * @var \yii\web\View $this
 */
$this->registerCss('.item {min-width: 10em; margin: 10px 5px}');
$buttons = array_keys(array_fill(1, 37, 1));
?>
<div style="display: flex; flex-flow: row wrap; justify-content: space-around; align-content: flex-start">
    <?php foreach ($buttons as $button) : ?>
    <button class="btn btn-info item">Элемент <?= $button ?></button>
    <?php endforeach; ?>
</div>
