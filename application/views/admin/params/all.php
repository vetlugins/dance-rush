<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-title">
                <i class="fa fa-sitemap"></i>
                <h3><?php echo __('Список параметров сайта') ?></h3>
                <div class="pull-right box-toolbar">
                    <a href="/admin/<?php echo $params['module'] ?>/add" class="btn btn-xs btn-success"><?php echo __('Добавить') ?></a>
                </div>
            </div>
            <div class="box-body no-padding">
                <?php if(isset($settings)){ ?>
                    <ul class="nav nav-tabs">
                        <?php
                        $i = 1;
                        foreach($params['sections'] as $key=>$section){
                            if($i == 1) $active = 'class="active"';
                            else $active = '';

                            echo '<li '.$active.'><a href="#'.$key.'" data-toggle="tab">'.$section.'</a></li>';

                            $i++;
                        }
                        ?>
                    </ul>
                    <div class="tab-content table-responsive no-padding">
                        <?php
                        $n = 1;
                        foreach($params['sections'] as $key=>$section){
                            if($n == 1) $active = 'active';
                            else $active = '';
                            ?>
                            <div id="<?php echo $key ?>" class="tab-pane <?php echo $active ?>">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th style="width:30%"><?php echo __('Название параметра') ?></th>
                                        <th style="width:20%"><?php echo __('Идентификатор параметра') ?></th>
                                        <th style="width:40%"><?php echo __('Значение параметра') ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach($settings->section($key) as $set){

                                        $stroke = '';

                                        switch($set->type){
                                            case 'text': $stroke = $set->value;
                                                break;
                                            case 'image': $stroke = '
                                                <a href="/uploads/system/logo/'.$set->value.'" title="'.__('Изображение').'" class="btn btn-default btn-sm fancybox"><i class="fa fa-photo"></i> '.$set->value.'</a>';
                                                break;
                                            case 'checkbox':
                                                if($set->value == 1) $box_check = __('вкл'); else $box_check = __('выкл');
                                                $stroke = $box_check;
                                        }

                                        echo '<tr>
                                                <td><a href="/admin/params/'.$key.'/'.$set->name.'">'.$set->title.'</a></td>
                                                <td>'.$set->name.'</td>
                                                <td>'.$stroke.'</td>
                                              </tr>';
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php $n++;
                        }
                        ?>
                    </div>
                    <div class="clearfix"></div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>