<?php
if ($album->view == 1){
    $view = '<i class="fa fa-eye"></i>';
    $class_hide = 'btn-success';
}else{
    $class_hide = 'btn-warning';
    $view = '<i class="fa fa-eye-slash"></i>';
}

$date = new DateFormat($album->created_at);

/*if(!empty($news->image)) $icon_image = '<a href="/uploads/photo/original/'.$album->photo->cover().'" title="Обложка" class="btn btn-default btn-sm fancybox"  data-toggle="tooltip"><i class="fa fa-photo"></i></a>';
else $icon_image = '<a title="Обложка отсутствует" class="btn btn-default btn-sm"  data-toggle="tooltip"><i class="fa fa-photo"></i></a>';*/

echo '<div class="col-md-3">
        <div class="box">
            <div class="box-title">
                <h3><a href="/admin/'.$params['module'].'/album/'.$album->id.'">'.$album->title.'</a></h3>
            </div>
            <div class="box-body no-padding">
                <img src="/uploads/photo/thumbs/'.$album->cover().'" class="image" style="width:100%">
            </div>
            <div class="box-footer">
                <span title="Фотографий" data-toggle="tooltip"><i class="fa fa-photo"></i> '.$album->photos->count_all().'</span>

                <span class="pull-right" title="Удалить" data-toggle="tooltip"><a class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i></a></span>
                <span class="pull-right" style="margin-right:3px" title="Редактировать" data-toggle="tooltip"><a class="btn btn-xs btn-info"><i class="fa fa-pencil"></i></a></span>
            </div>
        </div>
      </div>';