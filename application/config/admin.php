<?php defined('SYSPATH') OR die('No direct access allowed.');

return array(

    'title'       => 'VIA PANEL',
    'version'     => '2.0',
    'site'        => 'dancerush',
    'modules'     => array(
        'pages' => array(
            'title' => 'Страницы сайта',
            'icon' => 'sitemap',
            'route' => array(
                'show' =>  array(
                    'name' => 'admin-pages',
                    'uri' => 'admin/pages',
                    'directory' => 'Admin',
                    'controller' => 'Page',
                    'action' => 'index'
                ),
                'edit' =>  array(
                    'name' => 'admin-pages-edit',
                    'uri' => 'admin/pages/<id>',
                    'directory' => 'Admin',
                    'controller' => 'Page',
                    'action' => 'edit',
                    'uri_params' => array(
                        'id'	=> '[0-9]+'
                    )
                ),
                'add' =>  array(
                    'name' => 'admin-pages-add',
                    'uri' => 'admin/pages/add',
                    'directory' => 'Admin',
                    'controller' => 'Page',
                    'action' => 'add'
                ),
                'store' =>  array(
                    'name' => 'admin-pages-store',
                    'uri' => 'admin/pages/store',
                    'directory' => 'Admin',
                    'controller' => 'Page',
                    'action' => 'store'
                ),
                'update' =>  array(
                    'name' => 'admin-pages-update',
                    'uri' => 'admin/pages/update',
                    'directory' => 'Admin',
                    'controller' => 'Page',
                    'action' => 'update'
                )
            )
        )
    )
);
