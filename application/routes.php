<?php
/**
 * Languages
 */
$languages = array();
$config    = Kohana::$config->load('multilang');

$lang_param_page  = '<lang>(/<uri>)';
$lang_param_news  = array();
$lang_param_news_post  = array();
$lang_param_news_category  = array();
$lang_param_photo  = array();
$lang_param_photo_album  = array();

// Need a regex for all the available languages
foreach($config->languages as $lang => $settings)
{
    // If we hide the default language, we make lang parameter optional
    if($config->hide_default && $config->default == $lang)$lang_param_page = '(<lang>/)(<uri>)';
    else $languages[] = $lang;

    $lang_param_news[$lang]      = 'blog';
    $lang_param_news_post[$lang] = 'blog/<id>';
    $lang_param_news_category[$lang] = 'blog/category/<id>';
    $lang_param_photo[$lang] = 'photo';
    $lang_param_photo_album[$lang] = 'photo/<id>';
}

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */
// Пользователи сайта
Route::set('admin-users',        'admin/users')->defaults(['directory'  => 'Admin','controller' => 'Users']);
Route::set('admin-users-add',    'admin/users/add')->defaults(array('directory' => 'Admin','controller' => 'Users','action' => 'add'));
Route::set('admin-users-store',  'admin/users/store')->defaults(array('directory' => 'Admin','controller' => 'Users','action' => 'store'));
Route::set('admin-users-edit',   'admin/users/<id>/edit')->defaults(['directory' => 'Admin','controller' => 'Users','action' => 'edit']);
Route::set('admin-users-update', 'admin/users/update')->defaults(['directory' => 'Admin','controller' => 'Users','action' => 'update']);
Route::set('admin-users-logout', 'admin/users/logout')->defaults(['directory' => 'Admin','controller' => 'Users','action' => 'logout']);
Route::set('admin-users-remove', 'admin/users/<id>/remove')->defaults(['directory' => 'Admin','controller' => 'Users','action' => 'remove']);

//Статистика сайта
Route::set('admin-statistics', 'admin/statistics')->defaults(array('directory'  => 'Admin','controller' => 'Statistics'));

//Файловый менеджер
Route::set('admin-filemanager', 'admin/filemanager')->defaults(array('directory'  => 'Admin','controller' => 'Filemanager'));

// Параметры
Route::set('admin-params', 'admin/params')->defaults(array('directory'  => 'Admin','controller' => 'Params'));
Route::set('admin-params-edit', 'admin/params/<id>/<name>')->defaults(array('directory'  => 'Admin','controller' => 'Params','action' => 'edit'));
Route::set('admin-params-add', 'admin/params/add')->defaults(array('directory'  => 'Admin','controller' => 'Params','action' => 'add'));
Route::set('admin-params-store', 'admin/params/store')->defaults(array('directory'  => 'Admin','controller' => 'Params','action' => 'store'));
Route::set('admin-params-update', 'admin/params/update')->defaults(array('directory'  => 'Admin','controller' => 'Params','action' => 'update'));

// Видеогалерея
Route::set('admin-video-store', 'admin/video/store')->defaults(['directory'  => 'Admin','controller' => 'Video','action' => 'store']);
Route::set('admin-video-upload', 'admin/video/upload')
    ->defaults(array(
        'directory'  => 'Admin',
        'controller' => 'Video',
        'action' => 'upload'
    ));
Route::set('admin-video-show', 'admin/video/<id>')
    ->defaults(array(
        'directory'  => 'Admin',
        'controller' => 'Video',
        'action' => 'show'
    ));
Route::set('admin-video-album', 'admin/video')
    ->defaults(array(
        'directory'  => 'Admin',
        'controller' => 'Video',
        'action' => 'index'
    ));
// Фотогалерея
Route::set('admin-photo-upload', 'admin/photo/upload')
    ->defaults(array(
        'directory'  => 'Admin',
        'controller' => 'Photo',
        'action' => 'upload'
    ));
Route::set('admin-photo-show', 'admin/photo/album/<id>')
    ->defaults(array(
        'directory'  => 'Admin',
        'controller' => 'Photo',
        'action' => 'show'
    ));
Route::set('admin-photo-album', 'admin/photo')
    ->defaults(array(
        'directory'  => 'Admin',
        'controller' => 'Photo',
        'action' => 'index'
    ));
// blog
Route::set('admin-blog-setting', 'admin/blog/setting')
    ->defaults(array(
        'directory'  => 'Admin',
        'controller' => 'Blog',
        'action' => 'setting'
    ));
Route::set('admin-blog-comments', 'admin/blog/comments(/<id>)')
    ->defaults(array(
        'directory'  => 'Admin',
        'controller' => 'Blog',
        'action' => 'comments'
    ));
Route::set('admin-blog-update', 'admin/blog/update')
    ->defaults(array(
        'directory'  => 'Admin',
        'controller' => 'Blog',
        'action' => 'update'
    ));
Route::set('admin-blog-store', 'admin/blog/store')
    ->defaults(array(
        'directory'  => 'Admin',
        'controller' => 'Blog',
        'action' => 'store'
    ));
Route::set('admin-blog-article-add', 'admin/blog/article/add')
    ->defaults(array(
        'directory'  => 'Admin',
        'controller' => 'Blog',
        'action' => 'add'
    ));
Route::set('admin-blog-category-add', 'admin/blog/category/add')
    ->defaults(array(
        'directory'  => 'Admin',
        'controller' => 'Blog',
        'action' => 'add'
    ));
Route::set('admin-blog-article-edit', 'admin/blog/article/<id>', array(
    'id'	=> '[0-9]+'
))
    ->defaults(array(
        'directory'  => 'Admin',
        'controller' => 'Blog',
        'action' => 'edit'
    ));
Route::set('admin-blog-category-edit', 'admin/blog/category/<id>', array(
    'id'	=> '[0-9]+'
))
    ->defaults(array(
        'directory'  => 'Admin',
        'controller' => 'Blog',
        'action' => 'edit'
    ));
Route::set('admin-blog-article', 'admin/blog/article')
    ->defaults(array(
        'directory'  => 'Admin',
        'controller' => 'Blog',
        'action' => 'article'
    ));
Route::set('admin-blog-category', 'admin/blog/category')
    ->defaults(array(
        'directory'  => 'Admin',
        'controller' => 'Blog',
        'action' => 'category'
    ));
// страницы
Route::set('admin-pages-edit', 'admin/pages/<id>', array(
    'id'	=> '[0-9]+'
))
    ->defaults(array(
        'directory'  => 'Admin',
        'controller' => 'Page',
        'action' => 'edit'
    ));
Route::set('admin-pages-update', 'admin/pages/update')
    ->defaults(array(
        'directory'  => 'Admin',
        'controller' => 'Page',
        'action' => 'update'
    ));
Route::set('admin-pages-store', 'admin/pages/store')
    ->defaults(array(
        'directory'  => 'Admin',
        'controller' => 'Page',
        'action' => 'store'
    ));
Route::set('admin-pages-add', 'admin/pages/add')
    ->defaults(array(
        'directory'  => 'Admin',
        'controller' => 'Page',
        'action' => 'add'
    ));
Route::set('admin-pages', 'admin/pages')
    ->defaults(array(
        'directory'  => 'Admin',
        'controller' => 'Page',
        'action' => 'index'
    ));
// index
Route::set('admin', 'admin(/<action>)')
    ->defaults(array(
        'directory'  => 'Admin',
        'controller' => 'Home'
    ));
// Вход в админку
Route::set('login', 'login')
    ->defaults(array(
        'controller' => 'Login'
    ));
Route::set('admin-ajax', 'admin/ajax/<action>(/<id>)')
    ->defaults(array(
        'directory'  => 'Admin',
        'controller' => 'Ajax'
    ));
// ПОЛЬЗОВАТЕЛЬСКИЙ ИНТРЕФЭЙС
// ajax
Route::set('ajax', 'ajax/<lang>/<action>(/<id>)')
    ->defaults(array(
        'controller' => 'Ajax'
    ));

Routes::set('photo-album', $lang_param_photo_album, array(
    'lang'	=> '('.implode('|', $languages).')',
))->defaults(array(
    'controller'    => 'Photo',
    'action'        => 'album',
    'lang'			=> $config->default,
));

Routes::set('photo', $lang_param_photo, array(
    'lang'	=> '('.implode('|', $languages).')',
))->defaults(array(
    'controller'    => 'Photo',
    'lang'			=> $config->default,
));

// Блог
Routes::set('blog-post-category', $lang_param_news_category, array(
    'lang'	=> '('.implode('|', $languages).')',
))->defaults(array(
    'controller'    => 'Blog',
    'action'        => 'category',
    'lang'			=> $config->default,
));
Routes::set('blog-post', $lang_param_news_post, array(
    'lang'	=> '('.implode('|', $languages).')',
))->defaults(array(
    'controller'    => 'Blog',
    'action'        => 'show',
    'lang'			=> $config->default,
));

Routes::set('blog', $lang_param_news, array(
    'lang'	=> '('.implode('|', $languages).')',
))->defaults(array(
    'controller'    => 'Blog',
    'lang'			=> $config->default,
));

Route::set('default', $lang_param_page, ['lang'	=> '('.implode('|', $languages).')','uri'	=> '.*','page'	=> '[0-9]+'])->defaults(['controller' => 'Page','lang' => $config->default]);