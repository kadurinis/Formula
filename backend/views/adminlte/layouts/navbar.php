<?php

use yii\helpers\Html;

?>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <div style="margin-left: 7px">
        <h3 style="position: absolute; bottom:0">
        <?php
        if ($this->title && !isset($this->params['hideTitle'])) {
            echo \yii\helpers\Html::encode($this->title);
        }
        ?>
        </h3>
    </div>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <?php if (!Yii::$app->user->isGuest) : ?>
        <li class="nav-item">
            <?= Html::a('Выйти', ['site/logout'], ['role' => 'button', 'class' => 'nav-link']) ?>
        </li>
        <?php endif ?>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->
