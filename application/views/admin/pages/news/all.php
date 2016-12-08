<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-title no-padding">
                <div class="col-md-2" style="padding: 10px 0 0 10px">
                    <h3>
                        <i class="fa fa-book"></i>
                        Все новости
                    </h3>
                </div>
                <ul class="nav nav-tabs col-md-6 no-bordered">
                    <?php
                    $i = 1;
                    foreach($languages as $lang){
                        if($i == 1) echo '<li class="active"><a href="#'.$lang->i18n.'" data-toggle="tab">'.$lang->label.'</a></li>';
                        else echo '<li><a href="#'.$lang->i18n.'" data-toggle="tab">'.$lang->label.'</a></li>';
                        $i++;
                    }
                    ?>
                </ul>
                <div class="col-md-4" style="padding: 5px 10px 0 0">
                    <a href="/admin/<?php echo $params['module'] ?>/add" class="btn btn-sm btn-success pull-right" style="margin-left: 10px">Добавить новость</a>
                    <a href="/admin/<?php echo $params['module'] ?>/setting" class="btn btn-sm btn-primary pull-right" style="margin-left: 10px">Настройки</a>
                </div>
            </div>
            <div class="box-body no-padding">
                <div class="tab-content table-responsive">
                    <?php
                    if(isset($items)){
                        $i = 1;
                        foreach($languages as $lang){

                            if($i == 1) $status = ' active';
                            else $status = '';

                            echo '<div id="'.$lang->i18n.'" class="tab-pane'.$status.'">
                             <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Название</th>
                                    <th>Автор</th>
                                    <th>Дата</th>
                                    <th class="text-center"><i class="fa fa-eye" title="Просмотры" data-toggle="tooltip"></i></th>
                                    <th class="text-center"><i class="fa fa-comments" title="Комментарии" data-toggle="tooltip"></i></th>
                                    <th>Действия</th>
                                </tr>
                                </thead><tbody>';
                            if(isset($items[$lang->i18n])) echo $items[$lang->i18n];
                            echo '</tbody></table></div>';

                            $i++;
                        }
                    }else{
                        echo '<div class="alert alert-info margin-top-sm margin-bottom-sm">Новостей на сайте еще нет</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
