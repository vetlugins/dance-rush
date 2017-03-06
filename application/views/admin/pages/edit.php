<?php
if(isset($id)) $action = $params['url_site_admin'].'/'.$params['module'].'/update';
else $action = $params['url_site_admin'].'/'.$params['module'].'/store';
?>
<form id="formPage" action="<?php echo $action ?>" class="form-horizontal" role="form" method="post">

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
                    <h3><?php echo __('Содержимое страницы') ?></h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="title" class="col-sm-12"><?php echo __('Название страницы') ?></label>
                        <div class="col-sm-12">
                            <input type="text" value="<?php if(isset($item)) echo $item->title ?>" name="title" class="form-control" id="title" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12" for="text"><?php echo __('Текст страницы') ?></label>
                        <div class="col-sm-12">
                            <textarea name="text" id="text" placeholder="<?php echo Kohana::message('admin', 'fields.'.$params['module'].'.text') ?>"><?php if(isset($item)) echo $item->text ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="box">
                <div class="box-title">
                    <i class="fa fa-gears"></i>
                    <h3><?php echo __('Параметры') ?></h3>
                </div>
                <div class="box-body no-padding">
                    <div class="panel-group">
                        <div class="panel-group no-border" id="accordion">

                            <div class="panel panel-default no-border">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <i class="fa fa-signal"></i>
                                        <a data-toggle="collapse" data-parent="#accordion" href="#seo"><?php echo __('SEO. Meta теги') ?></a>
                                    </h4>
                                </div>
                                <div id="seo" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label for="url" class="col-sm-12"><?php echo __('URL страницы') ?></label>
                                            <div class="col-sm-12">
                                                <input type="text" name="url" value="<?php if(isset($item)) echo $item->url ?>" class="form-control" id="url" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="meta_title" class="col-sm-12"><?php echo __('Название, тэг title') ?></label>
                                            <div class="col-sm-12">
                                                <input type="text" placeholder="<?php echo Kohana::message('admin', 'fields.'.$params['module'].'.meta_title') ?>" value="<?php if(!empty($item)) echo $item->meta_title ?>" name="meta_title"  class="form-control" id="meta_title">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="meta_keyword" class="col-sm-12"><?php echo __('Ключевые слова') ?></label>
                                            <div class="col-sm-12">
                                                <input type="text" placeholder="<?php echo Kohana::message('admin', 'fields.'.$params['module'].'.meta_keyword') ?>" value="<?php if(!empty($item)) echo $item->meta_keyword ?>" name="meta_keyword"  class="form-control" id="meta_keyword">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="meta_description" class="col-sm-12"><?php echo __('Описание') ?></label>
                                            <div class="col-sm-12">
                                                <input type="text" placeholder="<?php echo Kohana::message('admin', 'fields.'.$params['module'].'.meta_description') ?>" value="<?php if(!empty($item)) echo $item->meta_description ?>" name="meta_description" class="form-control" id="meta_description">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default no-border">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <i class="fa fa-cogs"></i>
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse2"><?php echo __('Настройки') ?></a>
                                    </h4>
                                </div>
                                <div id="collapse2" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label for="lang" class="col-sm-12"><?php echo __('Язык страницы') ?></label>
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
                                            <label for="parent_id" class="col-sm-12"><?php echo __('Родитель страницы') ?></label>
                                            <div class="col-sm-12">
                                                <select class="form-control" name="parent_id" id="parent_id">
                                                    <option value="0"><?php echo __('Нет') ?></option>
                                                    <?php if(isset($pages_option)) echo $pages_option; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="target" class="col-sm-12"><?php echo __('Метод открытия') ?></label>
                                            <div class="col-sm-12">
                                                <select class="form-control" name="target" id="target">
                                                    <option value="self" <?php if(!empty($item)) if($item->target == 'self') echo 'selected' ?>><?php echo __('В текущем окне') ?></option>
                                                    <option value="blank" <?php if(!empty($item)) if($item->target == 'blank') echo 'selected' ?>><?php echo __('В новой вкладке') ?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="redirect" class="col-sm-12"><?php echo __('Переадресация') ?></label>
                                            <div class="col-sm-12">
                                                <input type="text" name="redirect"  value="<?php if(!empty($item)) echo $item->redirect ?>" class="form-control" id="redirect">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="access" class="col-sm-3 control-label"><?php echo __('Доступ') ?></label>
                                            <div class="col-sm-9">
                                                <select class="form-control" name="access" id="access">
                                                    <?php
                                                    if(isset($roles)){
                                                        foreach($roles as $role){
                                                            if(isset($item) and $item->access == $role->name){
                                                                echo '<option value="'.$role->name.'" selected>'.$role->title.'</option>';
                                                            }else{
                                                                echo '<option value="'.$role->name.'">'.$role->title.'</option>';
                                                            }
                                                        }
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

                            <div class="panel panel-default no-border">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <i class="fa fa-bookmark-o"></i>
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse3"><?php echo __('Заголовки над меню') ?></a>
                                    </h4>
                                </div>
                                <div id="collapse3" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label for="icon" class="col-sm-12"><?php echo __('Иконка') ?></label>
                                            <div class="col-sm-12">
                                                <input type="text" value="<?php if(!empty($item)) echo $item->icon ?>"  name="icon" class="form-control" id="icon">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="sub" class="col-sm-12"><?php echo __('Текст') ?></label>
                                            <div class="col-sm-12">
                                                <input type="text" name="sub"  value="<?php if(!empty($item)) echo $item->sub ?>" class="form-control" id="sub">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

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
                    <input type="hidden" name="updated"  value="<?php echo date('Y-m-d H:i:s') ?>">
                    <input type="hidden" name="created"  value="<?php echo date('Y-m-d H:i:s') ?>">
                    <input type="hidden" name="user_updated"  value="<?php echo Auth::instance()->get_user()->id ?>">
                    <input type="hidden" name="user_created"  value="<?php echo Auth::instance()->get_user()->id ?>">
                    <button type="submit" name="addPage" class="btn btn-success pull-right" style="margin-left: 10px">
                        <?php echo __('Добавить') ?>
                    </button>
                    <a href="<?php echo $params['url_site_admin'] ?>/<?php echo $params['module'] ?>" class="btn btn-danger pull-right">
                        <?php echo __('Отмена') ?>
                    </a>
                <?php }else{ ?>
                    <input type="hidden" name="id"  value="<?php echo $id ?>">
                    <input type="hidden" name="updated"  value="<?php echo date('Y-m-d H:i:s') ?>">
                    <input type="hidden" name="user_updated"  value="<?php echo Auth::instance()->get_user()->id ?>">
                    <button type="submit" name="editPage" class="btn btn-success pull-right" style="margin-left: 10px">
                        <?php echo __('Редактировать') ?>
                    </button>
                    <a href="<?php echo $params['url_site_admin'] ?>/<?php echo $params['module'] ?>" class="btn btn-danger pull-right">
                        <?php echo __('Отмена') ?>
                    </a>
                <?php } ?>
            </div>
        </div>

    </div>

</form>