<div class="row">
    <div class="col-md-8">
        <div class="box">
            <div class="box-title">
                <i class="fa fa-gears"></i>
                <h3><?php echo __('Список параметров сайта') ?></h3>
                <div class="pull-right box-toolbar">
                    <a href="<?php echo Route::url('admin-params-add') ?>" class="btn btn-xs btn-success"><?php echo __('Добавить') ?></a>
                </div>
            </div>
            <div class="box-body no-padding">

            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="box">
            <div class="box-title">
                <i class="fa fa-folder-open"></i>
                <h3><?php echo __('Разделы') ?></h3>
                <?php if(Auth::instance()->logged_in('superadmin')) { ?>
                    <div class="pull-right box-toolbar">
                        <a id="0" class="btn btn-xs btn-success section-params"><?php echo __('Добавить') ?></a>
                    </div>
                <?php } ?>
            </div>
            <div class="box-body no-padding">
                <?php
                if(isset($sections)){

                    echo '<ul class="list-group">';

                    foreach($sections as $section){
                        echo '<li class="list-group-item">'.$section->title.' <span class="badge">'.$section->params->count_all().'</span></li>';
                    }

                    echo '</ul>';
                }
                ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="section-params" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="paramsSection" class="form-horizontal" role="form">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title" class="col-sm-4 control-label"><?php echo __('Название раздела') ?></label>
                        <div class="col-sm-8">
                            <input type="text" name="title" class="form-control required" id="title" placeholder="Название" >
                            <input type="hidden" name="section_id" id="section_id">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-sm-6">
                        <div class="pull-left">
                            <div class="result"></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo __('Закрыть') ?></button>
                        <input  type="submit" class="btn btn-success" id="buttonParamsSection">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>