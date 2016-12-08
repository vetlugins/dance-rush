<!DOCTYPE html>
<html lang="en">
<head>

    <title><?php echo $data->title ?><?php  echo $params['title']?></title>

    <meta name="viewport" content="initial-scale=1.0, width=device-width" />
    <meta charset="utf-8">

    <meta name="description" content="<?php echo $data->meta_description ?>" />
    <meta name="keywords" content="<?php echo $data->meta_keyword ?>" />
    <meta name="author" content="Ветлугин Александр - vetlugins.com" />

    <link rel="shortcut icon" href="/favicon.ico">

    <?php
    if(isset($styles)){
        foreach($styles as $style) echo '<link href="'.$params['theme'].'css/'.$style.'" rel="stylesheet" type="text/css" />';
    }
    if(isset($style_page)) echo '<link href="'.$params['theme'].'css/'.$style_page.'" rel="stylesheet" type="text/css" />';
    ?>
</head>
<body <?php if($data->url != 'index') echo 'class="bg" '?>>

<?php include('_includes/_navigation.php') ?>


<div class="<?php if($data->url != 'index') echo 'container '?>wrapper">
    <div class="row">
        <?php
        if($data->url != 'index') include('_includes/_breadcrumb.php');

        if(isset($content)) echo $content;

        if($data->url != 'index') include('_includes/_footer.php');
        ?>
    </div>
</div>

<?php
    include('_includes/_modal.php');

    if(isset($scripts)){
        foreach($scripts as $script) echo '<script type="text/javascript" src="'.$params['theme'].'js/'.$script.'"></script>';
    }
    if(isset($script_page)) echo '<script type="text/javascript" src="'.$params['theme'].'js/'.$script_page.'"></script>';
?>

</body>
</html>