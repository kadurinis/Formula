<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <span class="brand-text font-weight-light">Администрирование</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php

            use backend\models\search\RecipeWarning;
            use backend\models\search\SectionWarning;
            use yii\helpers\Html;

            echo \hail812\adminlte\widgets\Menu::widget([
                'items' => [
                    ['label' => 'Рецепты', 'header' => true],
                    ['label' => 'Список', 'url' => ['recipe/index'], 'icon' => 'list', 'badge' => ($c = RecipeWarning::getCount()) ? Html::tag('span', $c, ['class' => 'right badge badge-danger', 'title' => 'Конфликты']) : ''],
                    ['label' => 'Добавить', 'url' => ['recipe/edit'],  'icon' => 'plus'],

                    ['label' => 'Справочник', 'header' => true],
                    ['label' => 'Секции', 'url' => ['section/index'], 'icon' => 'folder-open', 'badge' => ($c = SectionWarning::getCount()) ? Html::tag('span', $c, ['class' => 'right badge badge-danger', 'title' => 'Конфликты']) : ''],
                    ['label' => 'Нутриенты', 'url' => ['nutrient/index'],  'icon' => 'book'],
                    ['label' => 'Типы', 'icon' => 'tag', 'url' => ['type/index']],

                    ['label' => 'Настройки', 'header' => true],
                    ['label' => 'Отображение', 'url' => ['display/index'],  'icon' => 'cog'],

                    ['label' => 'Статистика', 'header' => true],
                    ['label' => 'История', 'url' => ['history/index'],  'icon' => 'clock'],

                    ['label' => 'Экраны', 'header' => true],
                    ['label' => 'Основной', 'url' => Yii::$app->params['primary_display_url'],  'icon' => 'circle', 'target' => '_blank'],
                    ['label' => 'Дополнительный', 'url' => Yii::$app->params['secondary_display_url'],  'icon' => 'circle', 'target' => '_blank'],
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>