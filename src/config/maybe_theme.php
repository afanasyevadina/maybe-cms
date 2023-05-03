<?php
return [
    'primitives' => [
        'navbar' => [
            'title' => 'Хедер',
            'structure' => [
                [
                    'slug' => 'background',
                    'title' => 'Фон',
                    'field_type' => 'select',
                    'options' => [
                        'bg-white' => 'Белый',
                        'bg-light' => 'Светлый',
                        'bg-dark' => 'Темный',
                        'bg-blue' => 'Голубой',
                    ]
                ],
                [
                    'slug' => 'logo',
                    'title' => 'Лого',
                    'field_type' => 'image',
                ],
                [
                    'slug' => 'text',
                    'title' => 'Заголовок',
                    'field_type' => 'text',
                ],
                [
                    'slug' => 'css',
                    'title' => 'Свой стиль',
                    'field_type' => 'text',
                ],
            ],
            'children' => ['navbar-nav'],
            'class' => 'fas fa-bars',
            'root' => true,
        ],
        'navbar-nav' => [
            'title' => 'Меню в шапке',
            'structure' => [],
            'children' => ['text', 'link'],
            'class' => 'fas fa-bars',
        ],
        'section' => [
            'title' => 'Секция',
            'structure' => [
                [
                    'slug' => 'background',
                    'title' => 'Фон',
                    'field_type' => 'select',
                    'options' => [
                        'bg-white' => 'Белый',
                        'bg-light' => 'Светлый',
                        'bg-dark' => 'Темный',
                        'bg-blue' => 'Голубой',
                    ],
                    'w' => 'col-lg-4',
                ],
                [
                    'slug' => 'width',
                    'title' => 'Ширина',
                    'field_type' => 'select',
                    'options' => [
                        'w-100' => '100%',
                        'w-75' => '75%',
                        'w-50' => '50%',
                        'w-33' => '33%',
                        'w-25' => '25%',
                        'w-auto' => 'Авто',
                    ],
                    'w' => 'col-lg-4',
                ],
                [
                    'slug' => 'rounds',
                    'title' => 'Скругление',
                    'field_type' => 'select',
                    'options' => [
                        'rounds-0' => 'Обычная',
                        'rounds-rounded' => 'Скругленные углы',
                        'rounds-circle' => 'Круглая',
                    ],
                    'w' => 'col-lg-4',
                ],
                [
                    'slug' => 'display',
                    'title' => 'Отображение контента',
                    'field_type' => 'select',
                    'options' => [
                        'd-column' => 'Столбцом',
                        'd-row' => 'Строкой',
                    ],
                    'w' => 'col-lg-4',
                ],
                [
                    'slug' => 'align-v',
                    'title' => 'Вертикальное выравнивание',
                    'field_type' => 'select',
                    'options' => [
                        'align-v-center' => 'По центру',
                        'align-v-top' => 'Прибить к верху',
                        'align-v-bottom' => 'Прибить к низу',
                        'align-v-stretch' => 'Растянуть',
                    ],
                    'w' => 'col-lg-4',
                ],
                [
                    'slug' => 'align-h',
                    'title' => 'Горизонтальное выравнивание',
                    'field_type' => 'select',
                    'options' => [
                        'align-h-center' => 'По центру',
                        'align-h-left' => 'Прибить влево',
                        'align-h-right' => 'Прибить вправо',
                        'align-h-between' => 'Распределить к краям',
                        'align-h-around' => 'Распределить равномерно',
                    ],
                    'w' => 'col-lg-4',
                ],
                [
                    'slug' => 'css',
                    'title' => 'Свой стиль',
                    'field_type' => 'text',
                ],
            ],
            'children' => ['text', 'markdown', 'link', 'image', 'video', 'youtube', 'heading', 'cards', 'table', 'accordion', 'delimeter', 'section', 'preset', 'component'],
            'root' => true,
            'allow_source' => true,
            'class' => 'fas fa-folder',
        ],
        'cards' => [
            'title' => 'Карточки',
            'structure' => [
                [
                    'slug' => 'columns',
                    'title' => 'Количество в строке',
                    'field_type' => 'select',
                    'options' => [
                        'columns-2' => '2',
                        'columns-3' => '3',
                        'columns-4' => '4',
                        'columns-5' => '5',
                        'columns-6' => '6',
                    ],
                    'w' => 'col-lg-4',
                ],
                [
                    'slug' => 'cards_background',
                    'title' => 'Фон карточек',
                    'field_type' => 'select',
                    'options' => [
                        'cards-bg-white' => 'Белый',
                        'cards-bg-light' => 'Светлый',
                        'cards-bg-dark' => 'Темный',
                        'cards-bg-blue' => 'Голубой',
                    ],
                    'w' => 'col-lg-4',
                ],
                [
                    'slug' => 'cards_style',
                    'title' => 'Стиль карточек',
                    'field_type' => 'select',
                    'options' => [
                        'cards-style-grid' => 'Простая плитка',
                        'cards-style-flow' => 'Плавающие блоки',
                    ],
                    'w' => 'col-lg-4',
                ],
                [
                    'slug' => 'css',
                    'title' => 'Свой стиль',
                    'field_type' => 'text',
                ],
            ],
            'children' => ['card'],
            'class' => 'fas fa-grip',
        ],
        'card' => [
            'title' => 'Карточка',
            'structure' => [
                [
                    'slug' => 'url',
                    'title' => 'URL ссылки',
                    'field_type' => 'link',
                    'allow_source' => true,
                ],
                [
                    'slug' => 'css',
                    'title' => 'Свой стиль',
                    'field_type' => 'text',
                ],
            ],
            'class' => 'far fa-square',
            'children' => ['heading', 'text', 'image'],
            'allow_source' => true,
        ],
        'accordion' => [
            'title' => 'Аккордеон',
            'structure' => [
                [
                    'slug' => 'title',
                    'title' => 'Заголовок',
                    'field_type' => 'text',
                    'allow_source' => true,
                ],
                [
                    'slug' => 'css',
                    'title' => 'Свой стиль',
                    'field_type' => 'text',
                ],
            ],
            'class' => 'fas fa-up-down',
            'children' => ['heading', 'text', 'image', 'link', 'markdown', 'video', 'youtube'],
            'allow_source' => true,
        ],
        'table' => [
            'title' => 'Таблица',
            'structure' => [
                [
                    'slug' => 'css',
                    'title' => 'Свой стиль',
                    'field_type' => 'text',
                ],
            ],
            'class' => 'fas fa-table',
            'children' => ['table_header', 'table_row'],
        ],
        'table_header' => [
            'title' => 'Шапка таблицы',
            'structure' => [
                [
                    'slug' => 'css',
                    'title' => 'Свой стиль',
                    'field_type' => 'text',
                ],
            ],
            'class' => 'fas fa-table',
            'children' => ['table_cell'],
        ],
        'table_row' => [
            'title' => 'Строка таблицы',
            'structure' => [
                [
                    'slug' => 'css',
                    'title' => 'Свой стиль',
                    'field_type' => 'text',
                ],
            ],
            'class' => 'fas fa-table',
            'children' => ['table_cell'],
            'allow_source' => true,
        ],
        'table_cell' => [
            'title' => 'Ячейка таблицы',
            'structure' => [
                [
                    'slug' => 'css',
                    'title' => 'Свой стиль',
                    'field_type' => 'text',
                ],
            ],
            'class' => 'fas fa-table-cell-large',
            'children' => ['text', 'markdown', 'image'],
        ],
        'heading' => [
            'title' => 'Заголовок',
            'structure' => [
                [
                    'slug' => 'text',
                    'title' => 'Текст',
                    'field_type' => 'text',
                    'allow_source' => true,
                ],
                [
                    'slug' => 'level',
                    'title' => 'Уровень',
                    'field_type' => 'select',
                    'options' => [
                        'h1' => 'h1',
                        'h2' => 'h2',
                        'h3' => 'h3',
                        'h4' => 'h4',
                        'h5' => 'h5',
                        'h6' => 'h6',
                    ],
                    'w' => 'col-lg-6',
                ],
                [
                    'slug' => 'align',
                    'title' => 'Выравнивание',
                    'field_type' => 'select',
                    'options' => [
                        'align-left' => 'По левому краю',
                        'align-right' => 'По правому краю',
                        'align-center' => 'По центру',
                    ],
                    'w' => 'col-lg-6',
                ],
                [
                    'slug' => 'css',
                    'title' => 'Свой стиль',
                    'field_type' => 'text',
                ],
            ],
            'class' => 'fas fa-heading',
        ],
        'text' => [
            'title' => 'Текст',
            'structure' => [
                [
                    'slug' => 'text',
                    'title' => 'Текст',
                    'field_type' => 'text',
                    'allow_source' => true,
                ],
                [
                    'slug' => 'align',
                    'title' => 'Выравнивание',
                    'field_type' => 'select',
                    'options' => [
                        'align-left' => 'По левому краю',
                        'align-right' => 'По правому краю',
                        'align-center' => 'По центру',
                    ],
                    'w' => 'col-lg-6',
                ],
                [
                    'slug' => 'margin',
                    'title' => 'Отступ снизу',
                    'field_type' => 'select',
                    'options' => [
                        'margin-none' => 'Нет',
                        'margin-sm' => 'Маленький',
                        'margin-md' => 'Средний',
                        'margin-lg' => 'Большой',
                    ],
                    'w' => 'col-lg-6',
                ],
                [
                    'slug' => 'css',
                    'title' => 'Свой стиль',
                    'field_type' => 'text',
                ],
            ],
            'class' => 'fas fa-align-justify',
        ],
        'markdown' => [
            'title' => 'Markdown',
            'structure' => [
                [
                    'slug' => 'text',
                    'title' => 'Контент',
                    'field_type' => 'markdown',
                    'allow_source' => true,
                ],
                [
                    'slug' => 'css',
                    'title' => 'Свой стиль',
                    'field_type' => 'text',
                ],
            ],
            'class' => 'fas fa-code',
        ],
        'link' => [
            'title' => 'Ссылка',
            'structure' => [
                [
                    'slug' => 'text',
                    'title' => 'Текст ссылки',
                    'field_type' => 'single-line-text',
                    'allow_source' => true,
                    'w' => 'col-lg-6',
                ],
                [
                    'slug' => 'url',
                    'title' => 'URL ссылки',
                    'field_type' => 'link',
                    'allow_source' => true,
                    'w' => 'col-lg-6',
                ],
                [
                    'slug' => 'style',
                    'title' => 'Стиль ссылки',
                    'field_type' => 'select',
                    'options' => [
                        'link' => 'Ссылка',
                        'button' => 'Кнопка',
                    ],
                    'w' => 'col-lg-6',
                ],
                [
                    'slug' => 'target',
                    'title' => 'Режим открытия',
                    'field_type' => 'select',
                    'options' => [
                        '_self' => 'В текущей вкладке',
                        '_blank' => 'В новой вкладке',
                    ],
                    'w' => 'col-lg-6',
                ],
                [
                    'slug' => 'css',
                    'title' => 'Свой стиль',
                    'field_type' => 'text',
                ],
            ],
            'class' => 'fas fa-link',
        ],
        'image' => [
            'title' => 'Картинка',
            'structure' => [
                [
                    'slug' => 'alt',
                    'title' => 'Альтернативный текст',
                    'field_type' => 'single-line-text',
                ],
                [
                    'slug' => 'src',
                    'title' => 'Изображение',
                    'field_type' => 'image',
                    'allow_source' => true,
                ],
                [
                    'slug' => 'rounds',
                    'title' => 'Скругление',
                    'field_type' => 'select',
                    'options' => [
                        'rounds-0' => 'Обычная',
                        'rounds-rounded' => 'Скругленные углы',
                        'rounds-circle' => 'Круглая',
                    ],
                ],
                [
                    'slug' => 'css',
                    'title' => 'Свой стиль',
                    'field_type' => 'text',
                ],
            ],
            'class' => 'far fa-image',
        ],
        'video' => [
            'title' => 'Видео',
            'structure' => [
                [
                    'slug' => 'src',
                    'title' => 'Видео',
                    'field_type' => 'video',
                    'allow_source' => true,
                ],
                [
                    'slug' => 'css',
                    'title' => 'Свой стиль',
                    'field_type' => 'text',
                ],
            ],
            'class' => 'fas fa-video',
        ],
        'youtube' => [
            'title' => 'Видео Youtube',
            'structure' => [
                [
                    'slug' => 'url',
                    'title' => 'URL',
                    'field_type' => 'link',
                ],
            ],
            'class' => 'fas fa-circle-play',
        ],
        'delimeter' => [
            'title' => 'Разделитель',
            'structure' => [
                [
                    'slug' => 'css',
                    'title' => 'Свой стиль',
                    'field_type' => 'text',
                ],
            ],
            'class' => 'fas fa-grip-lines',
            'root' => true,
        ],
    ],
];
