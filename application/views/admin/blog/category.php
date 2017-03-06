<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-title">
                <i class="fa fa-book"></i>
                <h3><?php echo __('Категории блога') ?></h3>
                <div class="pull-right box-toolbar">
                    <a href="/admin/<?php echo $params['module'] ?>/category/add?model=Blog_Category" class="btn btn-xs btn-success" style="margin-left: 10px"><?php echo __('Добавить') ?></a>
                </div>
            </div>
            <div class="box-body no-padding">
                <ul class="nav nav-tabs">
                    <?php
                    $i = 1;
                    foreach($languages as $lang){
                        if($i == 1) echo '<li class="active"><a href="#'.$lang->i18n.'" data-toggle="tab">'.$lang->label.'</a></li>';
                        else echo '<li><a href="#'.$lang->i18n.'" data-toggle="tab">'.$lang->label.'</a></li>';
                        $i++;
                    }
                    ?>
                </ul>
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
                                    <th class="text-center" style="width:2%">#</th>
                                    <th style="width:50%">'.__('Название').'</th>
                                    <th style="width:15%">'.__('Дата').'</th>
                                    <th class="text-center" style="width:5%"><i class="fa fa-eye" title="'.__('Просмотров').'" data-toggle="tooltip"></i></th>
                                    <th class="text-center" style="width:5%"><i class="fa fa-file-text" title="'.__('Статей').'" data-toggle="tooltip"></i></th>
                                    <th style="width:10%">'.__('Действия').'</th>
                                </tr>
                                </thead><tbody class="list-drag-n-drop">';
                            if(isset($items[$lang->i18n])) echo $items[$lang->i18n];
                            echo '</tbody></table></div>';

                            $i++;
                        }
                    }else{
                        echo '<div class="alert alert-info margin-top-sm margin-bottom-sm">'.__('Нет элементов для отображения').'</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>