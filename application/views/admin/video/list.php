<?php
if ($album->view == 1){
    $view = '<i class="fa fa-eye"></i>';
    $class_hide = 'btn-success';
}else{
    $class_hide = 'btn-warning';
    $view = '<i class="fa fa-eye-slash"></i>';
}

$date = new DateFormat($album->created_at) ;

if(!empty($album->cover())) $icon_image = '/uploads/video/'.$album->cover();
else $icon_image = '/uploads/system/nophoto.jpg';

if(count($album->videos()) > 0) $delete = '<a title="Есть видео" data-toggle="tooltip" class="btn btn-sm btn-default"><i class="fa fa-trash-o"></i></a>';
else $delete = '<a title="Удалить" data-toggle="tooltip" class="btn btn-sm btn-danger deleteAlbum" rel="'.$album->id.'"><i class="fa fa-trash-o"></i></a>';

echo '<li id="array_order_'.$album->id.'">
           <div class="item">
                <div class="pull-left" style="padding: 15px 0 0 10px">
                    <a href="/admin/'.$params['module'].'/'.$album->url.'" data-toggle="tooltip" title="Перейти к видео"><strong>'.$album->title.'</strong></a>
                </div>
                <div class="pull-right padding-sm">
                    <a href="/admin/'.$params['module'].'/'.$album->id.'" title="Перейти к видео" data-toggle="tooltip" class="btn btn-default btn-sm" ><i class="fa fa-photo"></i> '.count($album->videos()).'</a>
                    <a title="'.$date->get_date(Kohana::$config->load('site.date_format_admin')).'" data-toggle="tooltip" class="btn btn-default btn-sm"><i class="fa fa-calendar-o"></i></a>
                    <a href="'.$icon_image.'" title="Обложка" class="btn btn-default btn-sm fancybox"  data-toggle="tooltip"><i class="fa fa-photo"></i></a>
                    <a title="скрыть | показать" id="hideShow" class="btn '.$class_hide.' btn-sm"  data-toggle="tooltip" rel="'.$album->id.'">'.$view.'</a>
                    <a data-toggle="modal" data-target="#editAlbum" id="'.$album->id.'" title="Редактировать" data-toggle="tooltip" class="btn btn-sm btn-info editAlbum"><i class="fa fa-pencil"></i></a>
                    <a href="/admin/'.$params['module'].'/upload?album='.$album->url.'" title="Загрузить" data-toggle="tooltip" class="btn btn-sm btn-primary"><i class="fa fa-upload"></i></a>
                    '.$delete.'
                </div>
                <div class="clearfix"></div>
           </div>
      </li>';