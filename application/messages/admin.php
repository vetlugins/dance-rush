<?php defined('SYSPATH') or die('No direct script access.');

return array(
    'no' => 'Нет',
    'yes' => 'Да',
    'home' => 'Главная',

    'titles' => array(
        'default' => array(
            'menu_m_title' => 'Переключатель навигации',
            'panel_m_title' => 'Панель быстрого доступа',
            'count_alert' => 'Всего уведомлений',
            'go_to_site' => 'На сайт',
            'user_profile' => 'Мой профайл',
            'user_setting' => 'Мои настройки',
            'user_mail' => 'Мои письма',
            'user_logout' => 'Выход',
            'breadcrumb' => 'Вы здесь',
        ),
        'home' => array(
            'title' => 'Админстраторская панель',
            'description' => 'система контроля и управления сайтом',
            'statistics' => 'Посещаемость сайта за последнии 6 дней'
        ),
        'filemanager' => array(
            'title' => 'Файловый менеджер',
            'description' => 'управление файлами сайта с директории uploads',
        ),
        'pages' => array(
            'title' => 'Страницы сайта',
            'description' => 'управление основными и вспомогательными страницами сайта',
            'all_item' => 'Список страниц',
            'add_item' => 'Добавление страницы',
            'edit_item' => 'Редактирование страницы',
            'info' => 'Информация о странице'
        ),
        'blog' => array(
            'title' => array(
                'category' => 'Категории блога',
                'article' => 'Статьи блога',
                'comments' => 'Комментарии блога'
            ),
            'all_item' => array(
                'category' => 'Все категории',
                'article' => 'Все статьи',
                'comments' => 'Комментарии блога',
                'setting' => 'Настройки блога'
            ),
            'description' => 'управление новостным блоком сайта',
            'add_item' => array(
                'category' => 'Добавление категории',
                'article' => 'Добавление статьи'
            ),
            'edit_item' => array(
                'category' => 'Редактирование категории',
                'article' => 'Редактирование статьи'
            ),
            'info' => 'Информация о статье',
            'comments' => 'Комментарии',
            'setting' => 'Настройки'
        ),
        'photo' => array(
            'title' => 'Фотогалерея',
            'description' => 'управление фотографиями и фотоальбомами сайта',
            'all_item' => 'Все фотоальбомы',
            'add_item' => 'Добавление альбома',
            'edit_item' => 'Редактирование альбома',
            'info' => 'Информация об альбоме',
            'comments' => 'Комментарии',
            'setting' => 'Настройки',
            'upload_item' => 'Загрузка',
            'show_item' => 'Фотографии альбома'
        ),
        'video' => array(
            'title' => 'Видеогалерея',
            'description' => 'управление видео файлами и видео альбомами сайта',
            'all_item' => 'Все видео альбомы',
            'add_item' => 'Добавление альбома',
            'edit_item' => 'Редактирование альбома',
            'info' => 'Информация об альбоме',
            'comments' => 'Комментарии',
            'setting' => 'Настройки',
            'upload_item' => 'Загрузка',
            'show_item' => 'Видео альбома',
            'choose_album' => 'Выберите альбом для загрузки видео',
            'upload_in_album' => 'Загрузка видео в альбом'
        ),
        'params' => array(
            'title' => 'Параметры',
            'description' => 'управление настройками сайта',
            'all_item' => 'Список параметров сайта',
            'add_item' => 'Добавление альбома',
            'edit_item' => 'Редактирование параметра',
            'info' => 'Информация об альбоме',
            'comments' => 'Комментарии',
            'upload_item' => 'Загрузка',
            'show_item' => 'Видео альбома',
            'choose_album' => 'Выберите альбом для загрузки видео',
            'upload_in_album' => 'Загрузка видео в альбом'
        )
    ),

    'button' => array(
        'add'    => 'Добавить',
        'delete' => 'Удалить',
        'upload' => 'Загрузить',
        'cancel' => 'Отмена',
        'edit'   => 'Редактировать',
        'setting'   => 'Настройки',
        'comments'   => 'Комментарии',
        'select'   => 'Выбрать',
        'back'   => 'Назад'
    ),

    'alert' => array(
        'info' => array(
            'no_items' => 'Нет элементов для отображения'
        ),
        'success' => array(
            'sort'   => 'Положение элемента изменено',
            'delete_soft' => 'Запись успешно удалена',
            'create' => 'Запись успешно создана',
            'edit' => 'Запись успешно изменена'
        ),
        'error' => array(
            'create' => 'Не удалось создать запись'
        )
    ),

    'fields' => array(
        'pages' => array(
            'group_lang_parent' => 'Язык и родитель страницы',
            'lang'              => 'Язык страницы',
            'parent'            => 'Родитель страницы',
            'group_page'        => 'Содержимое страницы',
            'setting'           => 'Настройки страницы',
            'title'             => 'Название страницы',
            'url'               => 'URL страницы',
            'text'              => 'Содержимое страницы',
            'group_meta'        => 'SEO. Meta теги.',
            'meta_title'        => 'Название, тэг title',
            'meta_keyword'      => 'Ключевые слова',
            'meta_description'  => 'Описание',
            'icon'              => 'Иконка',
            'sub'               => 'Текст',
            'target'            => 'Метод открытия',
            'target_self'       => 'В текущем окне',
            'target_blank'      => 'В новой вкладке',
            'redirect'          => 'Переадресация',
            'access'            => 'Доступ',
            'visible'           => 'Видимость'
        ),
        'blog' => array(
            'lang'              => 'Язык',
            'comments'          => 'Комментарий',
            'articles'          => 'Статей',
            'short_text'        => 'Краткое описание',
            'full_text'         => 'Полное описание',
            'title'             => 'Название',
            'url'               => 'URL страницы',
            'text'              => 'Содержимое',
            'meta_title'        => 'Название',
            'meta_keyword'      => 'Ключевые слова',
            'meta_description'  => 'Описание',
            'views'             => 'Просмотры',
            'action'            => 'Действия',
            'target'            => 'Метод открытия',
            'target_self'       => 'В текущем окне',
            'target_blank'      => 'В новой вкладке',
            'date'              => 'Дата',
            'author'            => 'Автор',
            'visible'           => 'Видимость',
            'choose_image'      => 'Выберите обложку',
            'publish'           => 'Опубликовать',
            'fixed'             => 'Зафиксировать',
            'category'          => 'Категория'
        ),
        'params' => array(
            'title'             => 'Название параметра',
            'name'              => 'Идентификатор параметра',
            'group'             => 'Группа параметров',
            'value'             => 'Значение параметра'
        ),
        'photo' => array(
            'lang'              => 'Язык статьи',
            'comments'          => 'Комментарии',
            'short_text'         => 'Краткое описание',
            'full_text'         => 'Полное описание',
            'title'             => 'Название',
            'url'               => 'URL страницы',
            'text'              => 'Содержимое',
            'meta_title'        => 'Название',
            'meta_keyword'      => 'Ключевые слова',
            'meta_description'  => 'Описание',
            'views'             => 'Просмотры',
            'action'            => 'Действия',
            'target'            => 'Метод открытия',
            'target_self'       => 'В текущем окне',
            'target_blank'      => 'В новой вкладке',
            'date'              => 'Дата',
            'author'            => 'Автор',
            'visible'           => 'Видимость',
            'choose_image'      => 'Выберите обложку',
            'publish'           => 'Опубликовать'
        ),
        'video' => array(
            'lang'              => 'Язык статьи',
            'comments'          => 'Комментарии',
            'short_text'         => 'Краткое описание',
            'full_text'         => 'Полное описание',
            'title'             => 'Название',
            'url'               => 'URL страницы',
            'text'              => 'Содержимое',
            'meta_title'        => 'Название',
            'meta_keyword'      => 'Ключевые слова',
            'meta_description'  => 'Описание',
            'views'             => 'Просмотры',
            'action'            => 'Действия',
            'target'            => 'Метод открытия',
            'target_self'       => 'В текущем окне',
            'target_blank'      => 'В новой вкладке',
            'date'              => 'Дата',
            'author'            => 'Автор',
            'visible'           => 'Видимость',
            'choose_image'      => 'Выберите обложку',
            'publish'           => 'Опубликовать',
            'service'           => 'Видео хостинг',
            'select_hosting'    => 'Выберите хостинг',
            'url_video'         => 'Ссылка на видео',
            'image_video'       => 'Обложка видео',
            'html_video'        => 'HTML код'
        )
    ),

    'help' => array(
        'pages' => array(
            'hideShow' => 'скрыть | показать',
            'edit' => 'Редактировать',
            'delete' => 'Удалить',
            'not_delete' => 'Удалить нельзя'
        ),
        'blog' => array(
            'hideShow' => 'скрыть | показать',
            'edit' => 'Редактировать',
            'delete' => 'Удалить',
            'not_delete' => 'Удалить нельзя',
            'not_cover' => 'Обложка отсутствует',
            'cover' => 'Обложка',
            'trusted_format' => 'Допустимые форматы',
            'fixed' => 'Зафиксировано',
            'not_fixed' => 'Не зафиксировано'
        )
    )

);
