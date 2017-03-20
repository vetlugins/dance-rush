<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Flexible Migrations
 *
 * An open source migration module inspired by Ruby on Rails
 *
 * Reworked for Kohana by Fernando Petrelli
 *
 * Based on Migrations module by Jamie Madill
 *
 * @package		Flexiblemigrations
 * @author    Fernando Petrelli
 */


class Controller_Flexiblemigrations extends Controller_Admin_Common  {

  public $template = 'admin/default';
  protected $view;

	public function before() 
	{
		// Before anything, checks module installation
		$this->migrations = new Flexiblemigrations(TRUE);
		try 
		{
			$this->model = ORM::factory('Migration');
		} 
		catch (Database_Exception $a) 
		{
			echo 'Flexible Migrations is not installed. Please Run the migrations.sql script in your mysql server';
			exit();
		}

		parent::before();

		if (!Auth::instance()->logged_in('superadmin'))
		{
			HTTP::redirect('/admin');
		}

		$this->params['module'] = 'administration';
		$this->params['model'] = 'Administration';

		$this->page = array(
			'icon'=>'fa-user-secret',
			'title' => __('Администрирование'),
			'description' => __('секретный раздел администраторской панели')
		);

		$this->template->plugin_specific = array(
			'jgrowl/jquery.jgrowl',
			'switchery/switchery.min',
			'bootstrapValidator/bootstrapValidator.min',
			'fancybox/jquery.fancybox',
			'bootstrap-file-input/bootstrap-file-input',
			'datatables/jquery.dataTables',
			'datatables/dataTables.bootstrap',
		);
		$this->template->styles_specific = array(
			'switchery/switchery.min',
			'jgrowl/jquery.jgrowl',
			'bootstrapValidator/bootstrapValidator.min',
			'fancybox/jquery.fancybox',
		);
	}

	public function action_index() 
	{
		$migrations=$this->migrations->get_migrations();
		rsort($migrations);

		$this->page['breadcrumb'] = array(
			array($this->params['url_site_admin'] => __('Главная')),
			array(Route::url('admin-administration') => __('Администрирование')),
			array('current' => __('Миграции'))
		);

		//Get migrations already runned from the DB
		$migrations_runned = ORM::factory('Migration')->order_by('id','DESC')->find_all()->as_array('hash');

		$this->view = new View('admin/administration/migration');
		$this->view->set_global('migrations', $migrations);
		$this->view->set_global('migrations_runned', $migrations_runned);

		$this->template->content = $this->view;
	}

	public function action_new() 
	{
		if (Kohana::$config->load('data.status') != 'local') HTTP::redirect(Route::url('admin-administration-migrations'));

		$this->page['breadcrumb'] = array(
			array($this->params['url_site_admin'] => __('Главная')),
			array(Route::url('admin-administration') => __('Администрирование')),
			array(Route::url('admin-administration-migrations') => __('Миграции')),
			array('current' => __('Создать новую миграцию'))
		);

		$this->view = new View('admin/administration/migration_new');
		$this->template->content = $this->view;
	}

	public function action_create() 
	{
		$migration_name = str_replace(' ','_',$_REQUEST['migration_name']);
		$session = Session::instance();
		
		try 
		{
      		if (empty($migration_name)) 
      			throw new Exception('<div class="alert alert-danger">'.__('Необходимо указать название миграции').'</div>');

			$this->migrations->generate_migration($migration_name);

			//Sets a status message
			$session->set('message', '<div class="alert alert-success">'.__('Миграция ":value" была успешно создана. Проверьте папку для миграции', array(':value' => $migration_name)).'</div>');
	    } 
	    catch (Exception $e) 
	    { 
			$session->set('message',  $e->getMessage());
		}

	 	$this->redirect(Route::get('migrations_route')->uri());
	}

	public function action_migrate() 
	{
		$this->view = new View('admin/administration/migration_migrate');
		$this->template->content = $this->view;

		$this->page['breadcrumb'] = array(
			array($this->params['url_site_admin'] => __('Главная')),
			array(Route::url('admin-administration') => __('Администрирование')),
			array(Route::url('admin-administration-migrations') => __('Миграции')),
			array('current' => __('Миграция'))
		);
	
		$messages = $this->migrations->migrate();
		$this->view->set_global('messages', $messages);
	}

	// Todo Доделать rollback

	public function action_rollback() 
	{
		$this->view = new View('flexiblemigrations/rollback');
		$this->template->view = $this->view;

		$messages = $this->migrations->rollback();
		$this->view->set_global('messages', $messages);
	}

}
