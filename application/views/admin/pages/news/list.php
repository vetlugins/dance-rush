<?php
if ($news->view == 1){
    $view = '<i class="fa fa-eye"></i>';
    $class_hide = 'btn-success';
}else{
    $class_hide = 'btn-warning';
    $view = '<i class="fa fa-eye-slash"></i>';
}

$date = new DateFormat($news->created_at);

if(!empty($news->image)) $icon_image = '<a href="/uploads/news/original/'.$news->image.'" title="Обложка" class="btn btn-default btn-sm fancybox"  data-toggle="tooltip"><i class="fa fa-photo"></i></a>';
else $icon_image = '<a title="Обложка отсутствует" class="btn btn-default btn-sm"  data-toggle="tooltip"><i class="fa fa-photo"></i></a>';

echo '<tr>
           <td>'.$news->id.'</td>
           <td>'.$news->title.'</td>
           <td>'.$news->author->username.'</td>
           <td>'.$date->get_date(Kohana::$config->load('site.date_format_admin')).'</td>
           <td class="text-center">'.$news->views.'</td>
           <td class="text-center">'.$news->comments->where_soft()->count_all().'</td>
           <td>
                '.$icon_image.'
                <a title="скрыть | показать новость" id="hideShowNews" class="btn '.$class_hide.' btn-sm"  data-toggle="tooltip" rel="'.$news->id.'">'.$view.'</a>
                <a href="'.$params['url_site_admin'].'/'.$params['module'].'/'.$news->id.'" class="btn btn-info btn-sm" title="Редактировать" data-toggle="tooltip"><i class="fa fa-edit"></i></a>
                <a class="btn btn-danger btn-sm" title="Удалить"  id="delete" rel="'.$news->id.'"  data-toggle="tooltip"><i class="fa fa-trash-o"></i></a>
           </td>
      </tr>';