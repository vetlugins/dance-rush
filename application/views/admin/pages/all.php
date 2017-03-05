<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-title">
                <i class="fa fa-sitemap"></i>
                <h3><?php echo __('Список страниц') ?></h3>
                <div class="pull-right box-toolbar">
                    <a href="/admin/<?php echo $params['module'] ?>/add" class="btn btn-xs btn-success"><?php echo __('Добавить') ?></a>
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
                <div class="tab-content table-responsive padding">
                    <?php
                    if(isset($items) and count($items)){
                        $i = 1;
                        foreach($languages as $lang){

                            if($i == 1) $status = ' active';
                            else $status = '';

                            echo '<div id="'.$lang->i18n.'" class="tab-pane'.$status.'">
                                    <ul class="list-drag-n-drop no-margin no-padding">';
                            if(isset($items[$lang->i18n])) echo $items[$lang->i18n];
                            echo '  </ul>
                                 </div>';

                            $i++;
                        }
                    }else{
                        echo '<div class="alert alert-info margin-top-sm margin-bottom-sm">'.Kohana::message('admin', 'alert.info.no_items').'</div>';
                    }
                    ?>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>