<?php
if ($item->view == 1){
    $view = '<i class="fa fa-eye"></i>';
    $class_hide = 'btn-success';
}else{
    $class_hide = 'btn-warning';
    $view = '<i class="fa fa-eye-slash"></i>';
}

$date = new DateFormat($item->created_at);

echo '<tr id="array_order_'.$item->id.'">
           <td class="text-center">'.$item->id.'</td>
           <td>'.$item->title.'</td>
           <td>'.$date->get_date('d.F.Y в H:i').'</td>
           <td class="text-center">'.$item->views.'</td>
           <td class="text-center">'.$item->articles->articles($item->lang,'count').'</td>
           <td>
                <a title="'.__('Скрыть / Показать').'" id="hideShow" class="btn '.$class_hide.' btn-sm"  data-toggle="tooltip" rel="'.$item->id.'">'.$view.'</a>
                <a href="'.$params['url_site_admin'].'/'.$params['module'].'/category/'.$item->id.'?model=Blog_Category" class="btn btn-info btn-sm" title="'.__('Редактировать').'" data-toggle="tooltip"><i class="fa fa-edit"></i></a>
                <a class="btn btn-danger btn-sm" title="'.__('Удалить').'"  id="delete" rel="'.$item->id.'" data-toggle="tooltip"><i class="fa fa-trash-o"></i></a>
           </td>
      </tr>';