<?php defined('SYSPATH') or die('No direct script access.');

// -- Environment setup --------------------------------------------------------

// Load the core Kohana class
require SYSPATH.'classes/Kohana/Core'.EXT;

if (is_file(APPPATH.'classes/Kohana'.EXT))
{
	// Application extends the core
	require APPPATH.'classes/Kohana'.EXT;
}
else
{
	// Load empty core extension
	require SYSPATH.'classes/Kohana'.EXT;
}

/**
 * Set the default time zone.
 *
 * @link http://kohanaframework.org/guide/using.configuration
 * @link http://www.php.net/manual/timezones
 */
date_default_timezone_set('Europe/Moscow');

/**
 * Set the default locale.
 *
 * @link http://kohanaframework.org/guide/using.configuration
 * @link http://www.php.net/manual/function.setlocale
 */
setlocale(LC_ALL, 'ru_RU.utf-8');

/**
 * Enable the Kohana auto-loader.
 *
 * @link http://kohanaframework.org/guide/using.autoloading
 * @link http://www.php.net/manual/function.spl-autoload-register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Optionally, you can enable a compatibility auto-loader for use with
 * older modules that have not been updated for PSR-0.
 *
 * It is recommended to not enable this unless absolutely necessary.
 */
//spl_autoload_register(array('Kohana', 'auto_load_lowercase'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @link http://www.php.net/manual/function.spl-autoload-call
 * @link http://www.php.net/manual/var.configuration#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

/**
 * Set the mb_substitute_character to "none"
 *
 * @link http://www.php.net/manual/function.mb-substitute-character.php
 */
mb_substitute_character('none');

// -- Configuration and initialization -----------------------------------------

/**
 * Set the default language
 */
I18n::lang('ru-ru');

if (isset($_SERVER['SERVER_PROTOCOL']))
{
	// Replace the default protocol.
	HTTP::$protocol = $_SERVER['SERVER_PROTOCOL'];
}

/**
 * Set Kohana::$environment if a 'KOHANA_ENV' environment variable has been supplied.
 *
 * Note: If you supply an invalid environment name, a PHP warning will be thrown
 * saying "Couldn't find constant Kohana::<INVALID_ENV_NAME>"
 */
if (isset($_SERVER['KOHANA_ENV']))
{
	Kohana::$environment = constant('Kohana::'.strtoupper($_SERVER['KOHANA_ENV']));
}

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - integer  cache_life  lifetime, in seconds, of items cached              60
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 * - boolean  expose      set the X-Powered-By header                        FALSE
 */
Kohana::init(array(
	'base_url'   => '/',
	'index_file' => FALSE
));
/**
 * Cookie salt
 */
Cookie::$salt = 'super_puper_sait_dance_rush';

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Log_File(APPPATH.'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Config_File);

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(
	'auth'       => MODPATH.'auth',       // Basic authentication
	'cache'      => MODPATH.'cache',      // Caching with multiple backends
	'database'   => MODPATH.'database',   // Database access
	'image'      => MODPATH.'image',      // Image manipulation
	'orm'        => MODPATH.'orm',        // Object Relationship Mapping
	'settings'   => MODPATH.'settings',
	'multilang'  => MODPATH.'multilang',
));

/**
 * Languages
 */
$languages = array();
$config    = Kohana::$config->load('multilang');

$lang_param_page  = '<lang>(/<uri>)';
$lang_param_news  = array();
$lang_param_news_post  = array();

// Need a regex for all the available languages
foreach($config->languages as $lang => $settings)
{
	// If we hide the default language, we make lang parameter optional
	if($config->hide_default && $config->default == $lang)
	{
		$lang_param_page = '(<lang>/)(<uri>)';
	}
	else
	{
		$languages[] = $lang;
	}

	$lang_param_news[$lang]      = 'news(/<page>)';
	$lang_param_news_post[$lang] = 'news/<id>';
}

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */
// Фотогалерея
Route::set('admin-photo-album', 'admin/photo/album')
	->defaults(array(
		'directory'  => 'Admin',
		'controller' => 'Photo',
		'action' => 'album'
	));
// новости
Route::set('admin-news-setting', 'admin/news/setting')
	->defaults(array(
		'directory'  => 'Admin',
		'controller' => 'News',
		'action' => 'setting'
	));
Route::set('admin-news-edit', 'admin/news/<id>', array(
	'id'	=> '[0-9]+'
))
	->defaults(array(
		'directory'  => 'Admin',
		'controller' => 'News',
		'action' => 'edit'
	));
Route::set('admin-news-add', 'admin/news/add')
	->defaults(array(
		'directory'  => 'Admin',
		'controller' => 'News',
		'action' => 'add'
	));
Route::set('admin-news', 'admin/news')
	->defaults(array(
		'directory'  => 'Admin',
		'controller' => 'News',
		'action' => 'index'
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
		'controller' => 'Static'
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
Routes::set('news-post', $lang_param_news_post, array(
	'lang'	=> '('.implode('|', $languages).')',
))->defaults(array(
	'controller'    => 'News',
	'action'        => 'post',
	'lang'			=> $config->default,
));
Routes::set('news', $lang_param_news, array(
	'lang'	=> '('.implode('|', $languages).')',
	'page'	=> '[0-9]+'
))->defaults(array(
	'controller'    => 'News',
	'lang'			=> $config->default,
));
// for general pages
Route::set('default', $lang_param_page, array(
	'lang'	=> '('.implode('|', $languages).')',
	'uri'	=> '.*',
	'page'	=> '[0-9]+'
))->defaults(array(
	'controller'    => 'Page',
	'lang'			=> $config->default,
));
