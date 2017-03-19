<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $config->get('title'); ?> <?php echo $config->get('version'); ?></title>

    <!-- Maniac stylesheets -->
    <link rel="stylesheet" href="/templates/plugins/bootstrap/3.2.0/bootstrap.css" />
    <link rel="stylesheet" href="<?php echo $params['plugins'] ?>icon/css/font-awesome.css" />
    <link rel="stylesheet" href="<?php echo $params['plugins'] ?>animate/animate.css" />
    <link rel="stylesheet" href="<?php echo $params['plugins'] ?>alerts/jquery.alerts.css" />
    <?php foreach($styles_specific as $style_specific): ?>
        <link href="<?php echo $params['plugins'].$style_specific; ?>.css" rel="stylesheet" type="text/css" />
    <?php endforeach; ?>

    <link rel="stylesheet" href="<?php echo $params['theme'] ?>css/style.css" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="shortcut icon" href="<?php if(isset($params['theme'])) echo $params['theme'] ?>images/favicon.ico">


    <script src="http://momentjs.com/downloads/moment.js"></script>

</head>
<body class="fixed">
<!-- Header -->
<header>
    <a href="<?php echo URL::site('admin') ?>" class="logo"><i class="fa fa-bolt"></i> <span><?php echo $config->get('title'); ?> <?php echo $config->get('version'); ?></span></a>
    <nav class="navbar navbar-static-top">
        <a href="#" class="navbar-btn sidebar-toggle" style="margin: -2px 0 !important;">
            <span class="sr-only"><?php echo __('Переключатель навигации') ?></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <div class="navbar-header">
            <ul class="nav navbar-nav">

                <li class="dropdown dropdown-notifications">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-th-large"></i>
                    </a>
                    <ul class="dropdown-menu" style="width: 295px!important; height: 105px!important">
                        <li class="header"><i class="fa fa-th-large"></i>  <?php echo __('Панель быстрого доступа') ?></li>
                        <li>
                            <ul class="mega-menu">
                                <!--<li>
                                    <a href="/admin/clients/add">
                                        <span><i class="fa fa-users"></i></span>
                                        <span>Новый клиент</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/admin/portfolio/add">
                                        <span><i class="fa fa-briefcase"></i></span>
                                        <span>Новая работа</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/admin/news/add">
                                        <span><i class="fa fa-book"></i></span>
                                        <span>Добавить новость</span>
                                    </a>
                                </li>-->
                            </ul>
                        </li>
                        <li class="footer"></li>
                    </ul>
                </li>

                <li class="dropdown dropdown-notifications">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell"></i><span class="label label-warning"><?php //echo $new_item['i'] ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header"><i class="fa fa-bell"></i>  <?php echo __('Всего уведомлений') ?> <?php //echo $new_item['i'] ?></li>
                        <li>
                            <ul>
                                <?php //echo $new_item['new'] ?>
                            </ul>
                        </li>
                        <li class="footer"></li>
                    </ul>
                </li>


            </ul>
        </div>
        <div class="navbar-right">
            <a href="<?php echo URL::site() ?>" target="_blank" class="btn btn-primary  btn-outline"  style="padding: 5px 8px; margin: 8px 15px; border-radius: 0"><?php echo __('На Сайт') ?></a>
        </div>
    </nav>
</header>
<!-- /.header -->

<!-- wrapper -->
<div class="wrapper">
    <div class="leftside">
        <div class="sidebar">
            <div class="user-box">
                <div class="avatar">
                    <img src="<?php
                        echo Auth::instance()->get_user()->cover('small');
                    ?>" alt="" />
                </div>
                <div class="details">
                    <p><?php echo Auth::instance()->get_user()->username ?></p>
                </div>
                <div class="profile-btn">
                    <ul>
                        <li><a href="<?php echo $params['url_site_admin'] ?>/account/<?php echo Auth::instance()->get_user()->login ?>" title="<?php echo __('Мой профайл') ?>" data-toggle="tooltip"  data-placement="top"><i class="fa fa-user"></i></a></li>
                        <li><a href="" title="<?php echo __('Мои настройки') ?>" data-toggle="tooltip"  data-placement="top"><i class="fa fa-gears"></i></a></li>
                        <li><a href="<?php echo $params['url_site_admin'] ?>/mail/<?php echo Auth::instance()->get_user()->login ?>" title="<?php echo __('Мои письма') ?>" data-toggle="tooltip"  data-placement="top"><i class="fa fa-envelope"></i><span class="label label-warning"><?php // echo $new_mail ?></span></a></li>
                        <li><a href="<?php echo $params['url_site_admin'] ?>/users/logout" title="<?php echo __('Выход') ?>" data-toggle="tooltip"  data-placement="top"><i class="fa fa-power-off"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>

            </div>
            <ul class="sidebar-menu">
                <li <?php if($params['module'] == 'home') echo 'class="active"'; ?>>
                    <a href="<?php echo $params['url_site_admin'] ?>">
                        <i class="fa fa-home"></i> <span><?php echo __('Главная') ?></span>
                    </a>
                </li>

                <li class="sub-nav <?php
                    if(
                        $params['module'] == 'site_content' or
                        $params['module'] == 'pages' or
                        $params['module'] == 'blog' or
                        $params['module'] == 'photo' or
                        $params['module'] == 'video'
                    ) echo ' active';
                ?>">
                    <a href="#">
                        <i class="fa fa-briefcase"></i>
                        <span>Контент сайта</span>
                        <i class="fa fa-angle-right pull-right"></i>
                    </a>
                    <ul class="sub-menu">
                        <li <?php if($params['module'] == 'pages') echo 'class="active"'; ?>>
                            <a href="<?php echo $params['url_site_admin'] ?>/pages">
                                <i class="fa fa-sitemap"></i> <span>Страницы сайта</span>
                            </a>
                        </li>
                        <li class="sub-nav <?php if($params['module'] == 'blog') echo ' active'; ?>">
                            <a href="#">
                                <i class="fa fa-book"></i>
                                <span>Блог</span>
                                <i class="fa fa-angle-right pull-right"></i>
                            </a>
                            <ul class="sub-menu">
                                <li><a href="<?php echo $params['url_site_admin'] ?>/blog/category">Категории</a></li>
                                <li><a href="<?php echo $params['url_site_admin'] ?>/blog/article">Статьи</a></li>
                            </ul>
                        </li>
                        <li <?php if($params['module'] == 'photo') echo 'class="active"'; ?>>
                            <a href="<?php echo $params['url_site_admin'] ?>/photo">
                                <i class="fa fa-photo"></i> <span>Фотогалерея</span>
                            </a>
                        </li>
                        <li <?php if($params['module'] == 'video') echo 'class="active"'; ?>>
                            <a href="<?php echo $params['url_site_admin'] ?>/video">
                                <i class="fa fa-film"></i> <span>Видеогалерея</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li <?php if($params['module'] == 'users') echo 'class="active"'; ?>>
                    <a href="<?php echo $params['url_site_admin'] ?>/users">
                        <i class="fa fa-users"></i> <span>Пользователи</span>
                    </a>
                </li>
                <li <?php if($params['module'] == 'params') echo 'class="active"'; ?>>
                    <a href="<?php echo $params['url_site_admin'] ?>/params">
                        <i class="fa fa-gears"></i> <span>Параметры</span>
                    </a>
                </li>
                <li <?php if($params['module'] == 'statistics') echo 'class="active"'; ?>>
                    <a href="<?php echo $params['url_site_admin'] ?>/statistics">
                        <i class="fa fa-signal"></i> <span>Статистика</span>
                    </a>
                </li>
                <li <?php if($params['module'] == 'filemanager') echo 'class="active"'; ?>>
                    <a href="<?php echo $params['url_site_admin'] ?>/filemanager">
                        <i class="fa fa-folder-open-o"></i> <span>Файловый менеджер</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="rightside">

        <div class="page-head">
            <div class="icon-page">
                <i class="fa <?php if(isset($page)) echo $page['icon'] ?>"></i>
            </div>
            <h1><?php if(isset($page)) echo $page['title'] ?> <small><?php if(isset($page)) echo $page['description'] ?></small></h1>
            <ol class="breadcrumb">
                <li><?php echo __('Вы здесь') ?>:</li>
                <?php
                    if(isset($page)){
                        foreach($page['breadcrumb'] as $breadcrumb) {
                            foreach($breadcrumb as $key => $value) {
                                if($key != 'current') {
                                    echo '<li><a href="'.$key.'">'.$value.'</a></li>';
                                }else{
                                    echo '<li class="active">'.$value.'</li>';
                                }
                            }
                        }
                    }
                ?>
            </ol>
        </div>

        <div class="content">
            <?php if(isset($content)) echo $content ?>
        </div>

    </div>

</div><!-- /.wrapper -->


<!-- Javascript -->
<script src="/templates/plugins/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
<script src="/templates/plugins/jquery-ui/1.10.4/jquery-ui.min.js" type="text/javascript"></script>

<!-- Bootstrap -->
<script src="/templates/plugins/bootstrap/3.2.0/bootstrap.min.js" type="text/javascript"></script>

<script src="<?php echo $params['plugins'] ?>slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo $params['plugins'] ?>pace/pace.min.js" type="text/javascript"></script>
<script src="<?php echo $params['plugins'] ?>nicescroll/jquery.nicescroll.min.js" type="text/javascript"></script>
<script src="<?php echo $params['plugins'] ?>alerts/jquery.alerts.js" type="text/javascript"></script>
<script src="<?php echo $params['plugins'] ?>draggable/jquery.ui.draggable.js" type="text/javascript"></script>

<script src="<?php echo $params['theme'] ?>js/custom.js" type="text/javascript"></script>
<script src="<?php echo $params['theme'] ?>js/lang/ru.js" type="text/javascript"></script>

<?php foreach($plugin_specific as $specific): ?>
    <script type="text/javascript" src="<?php echo $params['plugins'].$specific; ?>.js"></script>
<?php endforeach; ?>

<script type="text/javascript" src="<?php echo $params['theme'] ?>js/<?php echo $params['module']; ?>.js"></script>

<script>
    var via_host_admin = '<?php echo $params['url_site_admin'] ?>';
    var via_host_skins_admin = '<?php echo $params['theme'] ?>';
    var model = '<?php if($params['model']) echo $params['model'] ?>';
</script>
</body>
</html>