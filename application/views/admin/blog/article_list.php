<?php
if ($item->view == 1){
    $view = '<i class="fa fa-eye"></i>';
    $class_hide = 'btn-success';
}else{
    $class_hide = 'btn-warning';
    $view = '<i class="fa fa-eye-slash"></i>';
}

$date = new DateFormat($item->created_at);

$cover = $item->cover();

if(!empty($cover)) $icon_image = '<a href="/uploads/'.$params['module'].'/original/'.$cover.'" title="'.__('Обложка').'" class="btn btn-default btn-sm fancybox"  data-toggle="tooltip"><i class="fa fa-photo"></i></a>';
else $icon_image = '<a title="'.__('Обложка отсутствует').'" class="btn btn-default btn-sm"  data-toggle="tooltip"><i class="fa fa-photo"></i></a>';

if($item->fixed == 0) $fixed = '<a title="'.__('Не зафиксировано').'" class="btn btn-default btn-sm"  data-toggle="tooltip"><i class="fa fa-thumb-tack"></i></a>';
else $fixed = '<a title="'.__('Зафиксировано').'" class="btn btn-primary btn-sm"  data-toggle="tooltip"><i class="fa fa-thumb-tack"></i></a>';

$comments = ORM::factory('Comments')->count($item->id,'Blog');

if($item->lang == Kohana::$config->load('lang.default') and Kohana::$config->load('lang.hide_default') == 1) $luri = '';
else $luri = $item->lang;

$site_page = ORM::factory('Page')->where('module','=',$params['module'])->find();

echo '<tr>
           <td><a href="'.$params['url_site_admin'].'/'.$params['module'].'/article/'.$item->id.'?model=Blog_Article">'.$item->title.'</a></td>
           <td>'.$date->get_date('d M Y H:i').'</td>
           <td>'.$item->category->title.'</td>
           <td class="text-center">'.$item->views.'</td>
           <td class="text-center">'.$comments.'</td>
           <td>
                '.$icon_image.'
                <a href="'.URL::site($luri.'/').$site_page->url.'/'.$item->url.'" target="_blank" class="btn btn-default btn-sm" title="URL"  data-toggle="tooltip"><i class="fa fa-link"></i></a>
                <a class="btn btn-default btn-sm" title="'.__('Автор').': '.$item->author->username.'"  data-toggle="tooltip"><i class="fa fa-user"></i></a>
                '.$fixed.'
                <a title="'.__('Скрыть / Показать').'" id="hideShow" class="btn '.$class_hide.' btn-sm"  data-toggle="tooltip" rel="'.$item->id.'">'.$view.'</a>
                <a class="btn btn-danger btn-sm" title="'.__('Удалить').'"  id="delete" rel="'.$item->id.'"  data-toggle="tooltip"><i class="fa fa-trash-o"></i></a>
           </td>
      </tr>';