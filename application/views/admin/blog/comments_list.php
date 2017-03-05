<?php
if ($item->view == 1){
    $view = '<i class="fa fa-eye"></i>';
    $class_hide = 'btn-success';
}else{
    $class_hide = 'btn-warning';
    $view = '<i class="fa fa-eye-slash"></i>';
}

if($item->user_id == 0){
    $username = $item->name;
    $city = $item->city;

    $image = '/uploads/system/no_avatar.jpg';
}else{
    $username = $item->author->username;
    $city = $item->author->city;

    if(is_file(DOCROOT.'uploads/users/'.$item->author->photo)) $image = '/uploads/users/'.$item->author->photo;
    else $image = '/uploads/system/no_avatar.jpg';
}

$date = new DateFormat($item->created_at);

echo '<tr>
                                    <td class="text-center" style="width:2%">'.$item->id.'</td>
                                    <td>'.$item->comment.'</td>
                                    <td>'.$item->article->title.'</th>
                                    <td>'.$date->get_date('d M Y H:i').'</td>
                                    <td>'.$username.'</td>
                                    <td>
                                        <a title="'.Kohana::message('admin', 'help.'.$params['module'].'.hideShow').'" id="hideShow" class="btn '.$class_hide.' btn-sm"  data-toggle="tooltip" rel="'.$item->id.'">'.$view.'</a>
                                        <a class="btn btn-danger btn-sm" title="'.Kohana::message('admin', 'help.'.$params['module'].'.delete').'"  id="delete" rel="'.$item->id.'" data-toggle="tooltip"><i class="fa fa-trash-o"></i></a>
                                    </td>
      </tr>';