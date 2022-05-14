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
                    [
                        'label' => 'Starter Pages',
                        'icon' => 'tachometer-alt',
                        'badge' => '<span class="right badge badge-info">2</span>',
                        'items' => [
                            ['label' => 'Active Page', 'url' => ['site/index'], 'iconStyle' => 'far'],
                            ['label' => 'Inactive Page', 'iconStyle' => 'far'],
                        ]
                    ],
                    ['label' => 'Simple Link', 'icon' => 'th', 'badge' => '<span class="right badge badge-danger">New</span>'],

                    ['label' => 'Справочник', 'header' => true],
                    ['label' => 'Секции', 'url' => ['section/index'], 'icon' => 'sign-in-alt', 'badge' => ($c = SectionWarning::getCount()) ? Html::tag('span', $c, ['class' => 'right badge badge-danger', 'title' => 'Конфликты']) : ''],
                    ['label' => 'Нутриенты', 'url' => ['nutrient/index'],  'icon' => 'file-code'],
                    ['label' => 'Типы', 'icon' => 'bug', 'url' => ['type/index']],

                    ['label' => 'Рецепты', 'header' => true],
                    ['label' => 'Список', 'url' => ['recipe/index'], 'icon' => 'sign-in-alt', 'badge' => ($c = RecipeWarning::getCount()) ? Html::tag('span', $c, ['class' => 'right badge badge-danger', 'title' => 'Конфликты']) : ''],
                    ['label' => 'Добавить', 'url' => ['recipe/edit'],  'icon' => 'file-code'],

                    ['label' => 'Настройки', 'header' => true],
                    ['label' => 'Отображение', 'url' => ['display/index'],  'icon' => 'file-code'],

                    ['label' => 'Статистика', 'header' => true],
                    ['label' => 'История', 'url' => ['history/index'],  'icon' => 'file-code'],


                    ['label' => 'Multi Level', 'header' => true],
                    ['label' => 'Level1'],
                    [
                        'label' => 'Level1',
                        'items' => [
                            ['label' => 'Level2', 'iconStyle' => 'far'],
                            [
                                'label' => 'Level2',
                                'iconStyle' => 'far',
                                'items' => [
                                    ['label' => 'Level3', 'iconStyle' => 'far', 'icon' => 'dot-circle'],
                                    ['label' => 'Level3', 'iconStyle' => 'far', 'icon' => 'dot-circle'],
                                    ['label' => 'Level3', 'iconStyle' => 'far', 'icon' => 'dot-circle']
                                ]
                            ],
                            ['label' => 'Level2', 'iconStyle' => 'far']
                        ]
                    ],
                    ['label' => 'Level1'],
                    ['label' => 'LABELS', 'header' => true],
                    ['label' => 'Important', 'iconStyle' => 'far', 'iconClassAdded' => 'text-danger'],
                    ['label' => 'Warning', 'iconClass' => 'nav-icon far fa-circle text-warning'],
                    ['label' => 'Informational', 'iconStyle' => 'far', 'iconClassAdded' => 'text-info'],
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>