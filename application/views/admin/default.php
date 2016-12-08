<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Администраторская :: VIA PANEL 2.0</title>

    <!-- Maniac stylesheets -->
    <link rel="stylesheet" href="<?php echo $params['theme'] ?>css/bootstrap.css" />
    <link rel="stylesheet" href="<?php echo $params['theme'] ?>css/font-awesome.min.css" />
    <link rel="stylesheet" href="<?php echo $params['theme'] ?>css/animate/animate.min.css" />

    <?php foreach($styles_specific as $style_specific): ?>
        <link href="<?php echo $params['theme'] ?>css/<?php echo $style_specific; ?>.css" rel="stylesheet" type="text/css" />
    <?php endforeach; ?>
    <link rel="stylesheet" href="<?php echo $params['theme'] ?>css/style.css" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="shortcut icon" href="<?php if(isset($params['theme'])) echo $params['theme'] ?>images/favicon.ico">

    <!--<script src="//api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>-->
</head>
<body class="fixed">
<!-- Header -->
<header>
    <a href="<?php echo URL::site('admin') ?>" class="logo"><i class="fa fa-bolt"></i> <span>VIA Panel</span></a>
    <nav class="navbar navbar-static-top">
        <a href="#" class="navbar-btn sidebar-toggle" style="margin: -2px 0 !important;">
            <span class="sr-only">Переключатель навигации</span>
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
                        <li class="header"><i class="fa fa-th-large"></i>  Панель быстрого доступа</li>
                        <li>
                            <ul class="mega-menu">
                                <li>
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
                                </li>
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
                        <li class="header"><i class="fa fa-bell"></i>  Всего уведомлений <?php //echo $new_item['i'] ?></li>
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
            <a href="<?php echo URL::site() ?>" target="_blank" class="btn btn-primary  btn-outline"  style="padding: 5px 8px; margin: 8px 15px; border-radius: 0">На сайт</a>
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
                    <img src="<?php echo  URL::base().'uploads/user/'.Auth::instance()->get_user()->photo ?>" alt="" />
                </div>
                <div class="details">
                    <p><?php echo Auth::instance()->get_user()->username ?></p>
                </div>
                <div class="profile-btn">
                    <ul>
                        <li><a href="<?php echo $params['url_site_admin'] ?>/account/<?php echo Auth::instance()->get_user()->login ?>" title="Мой профайл" data-toggle="tooltip"  data-placement="top"><i class="fa fa-user"></i></a></li>
                        <li><a href="" title="Мой настройки" data-toggle="tooltip"  data-placement="top"><i class="fa fa-gears"></i></a></li>
                        <li><a href="<?php echo $params['url_site_admin'] ?>/mail/<?php echo Auth::instance()->get_user()->login ?>" title="Мой письма" data-toggle="tooltip"  data-placement="top"><i class="fa fa-envelope"></i><span class="label label-warning"><?php // echo $new_mail ?></span></a></li>
                        <li><a href="<?php echo $params['url_site_admin'] ?>/account/logout" title="Выход" data-toggle="tooltip"  data-placement="top"><i class="fa fa-power-off"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>

            </div>
            <ul class="sidebar-menu">
                <li <?php if($params['module'] == 'home') echo 'class="active"'; ?>>
                    <a href="<?php echo $params['url_site_admin'] ?>">
                        <i class="fa fa-home"></i> <span>Главная</span>
                    </a>
                </li>
                <li <?php if($params['module'] == 'pages') echo 'class="active"'; ?>>
                    <a href="<?php echo $params['url_site_admin'] ?>/pages">
                        <i class="fa fa-sitemap"></i> <span>Страницы сайта</span>
                    </a>
                </li>
                <li <?php if($params['module'] == 'news') echo 'class="active"'; ?>>
                    <a href="<?php echo $params['url_site_admin'] ?>/news">
                        <i class="fa fa-book"></i> <span>Новости</span>
                    </a>
                </li>
                <li class="sub-nav <?php if($params['module'] == 'photo') echo ' active'; ?>">
                    <a href="#">
                        <i class="fa fa-photo"></i>
                        <span>Фотогалерея</span>
                        <i class="fa fa-angle-right pull-right"></i>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="<?php echo $params['url_site_admin'] ?>/photo/album">Альбомы</a></li>
                        <li><a href="<?php echo $params['url_site_admin'] ?>/photo/items">Фотографии</a></li>
                    </ul>
                </li>
                <li class="sub-nav <?php if($params['module'] == 'video') echo ' active'; ?>">
                    <a href="#">
                        <i class="fa fa-file-movie-o"></i>
                        <span>Видеогалерея</span>
                        <i class="fa fa-angle-right pull-right"></i>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="<?php echo $params['url_site_admin'] ?>/video/album">Альбомы</a></li>
                        <li><a href="<?php echo $params['url_site_admin'] ?>/video/items">Видео</a></li>
                    </ul>
                </li>
                <li class="sub-nav <?php if($params['module'] == 'site_content') echo ' active'; ?>">
                    <a href="#">
                        <i class="fa fa-briefcase"></i>
                        <span>Контент сайта</span>
                        <i class="fa fa-angle-right pull-right"></i>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="<?php echo $params['url_site_admin'] ?>/site_content/choreographers">Хореографы</a></li>
                        <li><a href="<?php echo $params['url_site_admin'] ?>/site_content/services">Услуги</a></li>
                        <li><a href="<?php echo $params['url_site_admin'] ?>/site_content/prices">Цены</a></li>
                    </ul>
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
                <li>Вы здесь:</li>
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
<script src="<?php echo $params['theme'] ?>js/plugins/jquery/jquery-1.10.2.min.js" type="text/javascript"></script>
<script src="<?php echo $params['theme'] ?>js/plugins/jquery-ui/jquery-ui-1.10.4.min.js" type="text/javascript"></script>

<script src="<?php echo $params['theme'] ?>js/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo $params['theme'] ?>js/plugins/pace/pace.min.js" type="text/javascript"></script>
<script src="<?php echo $params['theme'] ?>js/plugins/nicescroll/jquery.nicescroll.min.js" type="text/javascript"></script>

<!-- Bootstrap -->
<script src="<?php echo $params['theme'] ?>js/plugins/bootstrap/bootstrap.min.js" type="text/javascript"></script>
<?php foreach($plugin_specific as $p_specific): ?>
    <script type="text/javascript" src="<?php echo URL::base(); ?>templates/admin/js/plugins/<?php echo $p_specific; ?>.js"></script>
<?php endforeach; ?>

<script src="<?php echo $params['theme'] ?>js/custom.js" type="text/javascript"></script>

<?php foreach($script_specific as $specific): ?>
    <script type="text/javascript" src="<?php echo $params['theme'] ?>js/<?php echo $specific; ?>.js"></script>
<?php endforeach; ?>
<script>
    var via_host_admin = '<?php echo $params['url_site_admin'] ?>';
    var via_host_skins_admin = '<?php echo $params['theme'] ?>';

</script>
</body>
</html>