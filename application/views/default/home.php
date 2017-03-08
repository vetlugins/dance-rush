<!DOCTYPE html>
<html lang="en">
<head>

    <title><?php if(isset($item)){ echo  $item['title'].' :: ';} echo $data->meta_title ? $data->meta_title : $data->title ?> :: <?php echo Params::obtain('site_title') ?></title>

    <meta name="viewport" content="initial-scale=1.0, width=device-width" />
    <meta charset="utf-8">

    <meta name="description" content="<?php echo $data->meta_description ?>" />
    <meta name="keywords" content="<?php echo $data->meta_keyword ?>" />
    <meta name="author" content="Ветлугин Александр - vetlugins.com" />
    <meta name="yandex-verification" content="5f226f4d0b60b5a9" />

    <link rel="shortcut icon" href="/favicon.ico">

    <link href="<?php echo Params::plugins() ?>bootstrap/3.3.7/bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo Params::plugins() ?>rs-plugin/css/settings.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo Params::plugins() ?>rs-plugin/css/extralayers.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo Params::plugins() ?>icon/css/icomoon.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo Params::plugins() ?>owl/css/owl.carousel.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo Params::plugins() ?>owl/css/owl.transitions.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo Params::plugins() ?>animate/animate.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo Params::plugins() ?>fancybox/jquery.fancybox.css" rel="stylesheet" type="text/css" />

    <link href="<?php echo Params::theme() ?>css/style.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo Params::theme() ?>css/media.css" rel="stylesheet" type="text/css" />

    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

    <?php if (Kohana::$config->load('data.status') == 'published') include('_includes/_counter.php'); ?>

</head>
<body>

<div id="loader">
    <div class="loader"></div>
</div>

<?php
    include('_includes/_navigation.php');

    if($data->url != 'index') include('_includes/_breadcrumb.php');

    if(isset($content)) echo $content;

    include('_includes/_footer.php');

    include('_includes/_modal.php');

?>
<script src="<?php echo Params::plugins() ?>jquery/1.9.1/jquery.min.js"></script>
<script src="<?php echo Params::plugins() ?>bootstrap/3.3.7/bootstrap.min.js"></script>
<script src="<?php echo Params::plugins() ?>rs-plugin/js/jquery.themepunch.plugins.min.js"></script>
<script src="<?php echo Params::plugins() ?>rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
<script src="<?php echo Params::plugins() ?>validate/jquery.validate.min.js"></script>
<script src="<?php echo Params::plugins() ?>owl/js/owl.carousel.js"></script>
<script src="<?php echo Params::plugins() ?>fancybox/jquery.fancybox.js"></script>
<script src="<?php echo Params::plugins() ?>masonry/masonry.pkgd.min.js"></script>
<script src="<?php echo Params::plugins() ?>countTo/jquery.countTo.js"></script>
<script src="<?php echo Params::plugins() ?>inputmask/jquery.inputmask.js"></script>

<script src="<?php echo Params::theme() ?>js/custom.js"></script>
<script>var lang = '<?php echo $params['lang'] ?>'</script>
</body>
</html>