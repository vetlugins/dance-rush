<?php
if ($page->special == 1 or count($parents) > 0) $disabled = '<a class="btn btn-default btn-sm" title="Удалить нельзя"  data-toggle="tooltip"><i class="fa fa-trash-o"></i></a>';
else $disabled = '<a class="btn btn-danger btn-sm" title="Удалить"  id="delete" rel="'.$page->id.'"  data-toggle="tooltip"><i class="fa fa-trash-o"></i></a>';

if ($page->view == 1){
    $view = '<i class="fa fa-eye"></i>';
    $class_hide = 'btn-success';
}else{
    $class_hide = 'btn-warning';
    $view = '<i class="fa fa-eye-slash"></i>';
}

if(count($parents) > 0){
    $toggle = '<a class="btn btn-default btn-xs collapse-parent"><i class="fa fa-plus"></i></a>';
}else{
    $toggle = '<a class="btn btn-default btn-xs collapse-parent"><i class="fa fa-minus"></i></a>';
}

$user_created = ORM::factory('Auth_User')->where('id','=',$page->user_created)->find();
$user_updated = ORM::factory('Auth_User')->where('id','=',$page->user_updated)->find();

if(!empty($page->redirect)) $redirect = $page->redirect;
else $redirect = 'нет';

if($page->target == 'self') $target = 'в текущем окне';
else $target = 'в новой вкладке';

                        echo '<li id="array_order_'.$page->id.'">
                                    <div class="item">
                                        <div class="pull-left" style="padding: 15px 0 0 10px">
                                            '.$toggle.'
                                            <a href="/admin/pages/'.$page->id.'"><strong>'.$page->title.'</strong></a>
                                        </div>
                                        <div class="pull-right padding-sm">
                                            <a class="btn btn-primary btn-sm" title="Информация о странице" id="infoPage"  data-toggle="dropdown"><i class="fa fa-info"></i></a>
                                            <a title="скрыть | показать страницу" id="hideShowPage" class="btn '.$class_hide.' btn-sm"  data-toggle="tooltip" rel="'.$page->id.'">'.$view.'</a>
                                            <a href="/admin/pages/'.$page->id.'" class="btn btn-info btn-sm" title="Редактировать" data-toggle="tooltip"><i class="fa fa-edit"></i></a>
                                            '.$disabled.'
                                            <div class="infoPage dropdown-menu" role="menu">
                                                <h5>Информация о странице</h5>
                                                <p><small><i class="fa fa-flash"></i> '.$user_created->username.'. '.$page->created.'.</small></p>
                                                <p><small><i class="fa fa-edit"></i> '.$user_updated->username.'. '.$page->updated.'.</small></p>
                                                <p><small><i class="fa fa-mail-reply-all"></i> Переадресация: '.$redirect.'. <i class="fa fa-desktop"></i> '.$target.'</small></p>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>';

                        if(isset($get_parents) and count($parents) > 0){
                            echo '<ul class="list-drag-n-drop collapse parent">';
                            echo $get_parents;
                            echo '</ul>';
                        }

                        echo '</li>';