<?php
if(isset($id)) $action = $params['url_site_admin'].'/'.$params['module'].'/update';
else $action = $params['url_site_admin'].'/'.$params['module'].'/store';
?>
<form id="form" action="<?php echo $action ?>" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">

    <div class="row">

        <div class="margin-bottom-sm">
            <div class="col-md-12">
                <?php if(!empty($alert)) echo str_replace('validation.url.','',$alert) ?>
            </div>
        </div>

        <div class="col-md-8">
            <div class="box">
                <div class="box-title">
                    <i class="fa fa-pencil"></i>
                    <?php
                    if(isset($id) and !empty($item)){
                        echo '<h3>'.__('Редактирование категории').'</h3>';
                    }else echo '<h3>'.__('Добавление категории').'</h3>';
                    ?>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="title" class="col-sm-2 control-label"><?php echo __('Название') ?></label>
                        <div class="col-sm-10">
                            <input type="text" value="<?php if(isset($item)) echo $item->title ?>" name="title" class="form-control" id="title">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="url" class="col-sm-2 control-label">URL</label>
                        <div class="col-sm-10">
                            <input type="text" name="url" value="<?php if(isset($item)) echo $item->url ?>" class="form-control" id="url">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="box">
                <div class="box-title">
                    <i class="fa fa-gears"></i>
                    <?php echo '<h3>'.__('Параметры').'</h3>'?>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="lang" class="col-sm-12"><?php echo __('Язык категории') ?></label>
                        <div class="col-sm-12">
                            <select class="form-control" name="lang" id="lang">
                                <?php
                                foreach($languages as $lang){
                                    if(isset($item) and $item->lang == $lang->i18n) echo '<option value="'.$lang->i18n.'" selected>'.$lang->label.'</option>';
                                    else echo '<option value="'.$lang->i18n.'">'.$lang->label.'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="view" class="col-sm-3 control-label"><?php echo __('Видимость') ?></label>
                        <div class="col-sm-9">
                            <input id="view" name="view" value="1" type="checkbox" class="js-switch" <?php if(!empty($item)){ if($item->view == 1) echo 'checked'; }else{ echo 'checked';} ?>>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="margin-bottom-md">
            <div class="col-md-8">
            </div>
            <div class="col-md-4">
                <?php
                if(!isset($id)){
                    ?>
                    <input type="hidden" name="updated_at"  value="<?php echo date('Y-m-d H:i:s') ?>">
                    <input type="hidden" name="created_at"  value="<?php echo date('Y-m-d H:i:s') ?>">
                    <input type="hidden" name="user_updated"  value="<?php echo Auth::instance()->get_user()->id ?>">
                    <input type="hidden" name="user_created"  value="<?php echo Auth::instance()->get_user()->id ?>">
                    <input type="hidden" name="model"  value="<?php echo $_GET['model'] ?>">
                    <button type="submit" name="add" class="btn btn-success pull-right" style="margin-left: 10px">
                        <?php echo __('Добавить') ?>
                    </button>
                    <a href="<?php echo $params['url_site_admin'] ?>/<?php echo $params['module'] ?>/category" class="btn btn-danger pull-right">
                        <?php echo __('Отмена') ?>
                    </a>
                <?php }else{ ?>
                    <input type="hidden" name="id"  value="<?php echo $id ?>">
                    <input type="hidden" name="updated_at"  value="<?php echo date('Y-m-d H:i:s') ?>">
                    <input type="hidden" name="user_updated"  value="<?php echo Auth::instance()->get_user()->id ?>">
                    <input type="hidden" name="model"  value="<?php echo $_GET['model'] ?>">
                    <button type="submit" name="edit" class="btn btn-success pull-right" style="margin-left: 10px">
                        <?php echo __('Редактировать') ?>
                    </button>
                    <a href="<?php echo $params['url_site_admin'] ?>/<?php echo $params['module'] ?>/category" class="btn btn-danger pull-right">
                        <?php echo __('Отмена') ?>
                    </a>
                <?php } ?>
            </div>
        </div>

    </div>

</form>