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
                        echo '<h3>'.__('Редактирование статьи').'</h3>';
                    }else echo '<h3>'.__('Добавление статьи').'</h3>';
                    ?>
                </div>
                <div class="box-body">

                    <div class="form-group">
                        <label for="category_url" class="col-sm-12"><?php echo __('Категория') ?></label>
                        <div class="col-sm-12">
                            <select class="form-control" name="category_url" id="category_url">
                                <?php
                                if(!empty($category_option)) echo $category_option;
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="title" class="col-sm-12"><?php echo __('Название статьи') ?></label>
                        <div class="col-sm-12">
                            <input type="text" value="<?php if(isset($item)) echo $item->title ?>" name="title" class="form-control" id="title">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="url" class="col-sm-12"></label>
                        <div class="col-sm-12">
                            <ul class="nav nav-tabs no-bordered">
                                <li class="active"><a href="#news_description" data-toggle="tab"><label for="description"><?php echo __('Краткое описание') ?></label></a></li>
                                <li><a href="#news_text" data-toggle="tab"><label for="text"><?php echo __('Полное описание') ?></label></a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="news_description">
                                    <textarea name="description" id="description"><?php if(isset($item)) echo $item->description ?></textarea>
                                    <p class="help-block"><?php echo Kohana::message('admin', 'fields.'.$params['module'].'.short_text') ?></p>
                                </div>
                                <div class="tab-pane" id="news_text">
                                    <textarea name="text" id="text"><?php if(isset($item)) echo $item->text ?></textarea>
                                    <p class="help-block"><?php echo Kohana::message('admin', 'fields.'.$params['module'].'.full_text') ?></p>
                                </div>
                            </div>
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
                <div class="box-body no-padding">
                    <div class="panel-group">
                        <div class="panel-group no-border" id="accordion">

                            <div class="panel panel-default no-border">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <i class="fa fa-photo"></i>
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse3"><?php echo __('Обложка') ?></a>
                                    </h4>
                                </div>
                                <div id="collapse3" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label for="image"></label>
                                            <div class="col-sm-12 text-center">
                                                <input type="file" name="image" class="btn btn-info file-inputs" title="<?php echo __('Выберите файл') ?>">
                                                <p class="help-block"><?php echo __('Допустимые форматы') ?>: jpg, jpeg, png</p>
                                                <p>
                                                    <?php
                                                    if(isset($item) and !empty($item->cover())){
                                                    ?>
                                                    <p>
                                                        <a href="/uploads/<?php echo $params['module'] ?>/original/<?php echo $item->cover() ?>" class="fancybox"><img src="/uploads/<?php echo $params['module'] ?>/small/<?php echo $item->cover() ?>" class="img-thumbnail"></a>
                                                    </p>
                                                    <?php }else{ ?>
                                                        <p class="alert alert-info"><?php echo __('Обложка отсутствует') ?></p>
                                                    <?php } ?>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="comment" class="col-sm-8 control-label"><?php echo __('Показывать обложку в статье') ?></label>
                                            <div class="col-sm-4">
                                                <input id="comment" name="comment" value="1" type="checkbox" class="js-switch_4" <?php if(isset($item)){if($item->comment == 1){ echo 'checked';}}else{ echo 'checked';} ?> >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default no-border">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <i class="fa fa-signal"></i>
                                        <a data-toggle="collapse" data-parent="#accordion" href="#seo"><?php echo __('SEO. Meta теги') ?></a>
                                    </h4>
                                </div>
                                <div id="seo" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label for="url" class="col-sm-12"><?php echo __('URL статьи') ?></label>
                                            <div class="col-sm-12">
                                                <input type="text" name="url" value="<?php if(isset($item)) echo $item->url ?>" class="form-control" id="url" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="meta_title" class="col-sm-12"><?php echo __('Название, тэг title') ?></label>
                                            <div class="col-sm-12">
                                                <input type="text" value="<?php if(!empty($item)) echo $item->meta_title ?>" name="meta_title"  class="form-control" id="meta_title">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="meta_keyword" class="col-sm-12"><?php echo __('Ключевые слова') ?></label>
                                            <div class="col-sm-12">
                                                <input type="text" value="<?php if(!empty($item)) echo $item->meta_keyword ?>" name="meta_keyword"  class="form-control" id="meta_keyword">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="meta_description" class="col-sm-12"><?php echo __('Описание') ?></label>
                                            <div class="col-sm-12">
                                                <input type="text" value="<?php if(!empty($item)) echo $item->meta_description ?>" name="meta_description" class="form-control" id="meta_description">
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
                                            <label for="lang" class="col-sm-12"><?php echo __('Язык статьи') ?></label>
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
                                            <label for="date" class="col-sm-12"><?php echo __('Дата') ?></label>
                                            <div class="col-sm-12">
                                                <input type="text" value="<?php if(isset($item)) echo $item->created_at ?>" name="date" class="form-control datepicker-input" id="date">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="view" class="col-sm-4 control-label"><?php echo __('Опубликовать') ?></label>
                                            <div class="col-sm-8">
                                                <input id="view" name="view" value="1" type="checkbox" class="js-switch" <?php if(isset($item) and $item->view == 1){ echo 'checked';}else{ echo 'checked';} ?> >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="fixed" class="col-sm-4 control-label"><?php echo __('Зафиксировать') ?></label>
                                            <div class="col-sm-8">
                                                <input id="fixed" name="fixed" value="1" type="checkbox" class="js-switch_2" <?php if(isset($item) and $item->fixed == 1){ echo 'checked';} ?> >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="comment" class="col-sm-4 control-label"><?php echo __('Комментарии') ?></label>
                                            <div class="col-sm-8">
                                                <input id="comment" name="comment" value="1" type="checkbox" class="js-switch_3" <?php if(isset($item)){if($item->comment == 1){ echo 'checked';}}else{ echo 'checked';} ?> >
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
                    <input type="hidden" name="updated_at"  value="<?php echo date('Y-m-d H:i:s') ?>">
                    <input type="hidden" name="user_updated"  value="<?php echo Auth::instance()->get_user()->id ?>">
                    <input type="hidden" name="user_created"  value="<?php echo Auth::instance()->get_user()->id ?>">
                    <input type="hidden" name="model"  value="<?php echo $_GET['model'] ?>">
                    <button type="submit" name="addNews" class="btn btn-success pull-right" style="margin-left: 10px">
                        <?php echo __('Добавить') ?>
                    </button>
                    <a href="<?php echo $params['url_site_admin'] ?>/<?php echo $params['module'] ?>/article" class="btn btn-danger pull-right">
                        <?php echo __('Отмена') ?>
                    </a>
                <?php }else{ ?>
                    <input type="hidden" name="id"  value="<?php echo $id ?>">
                    <input type="hidden" name="updated_at"  value="<?php echo date('Y-m-d H:i:s') ?>">
                    <input type="hidden" name="user_updated"  value="<?php echo Auth::instance()->get_user()->id ?>">
                    <input type="hidden" name="model"  value="<?php echo $_GET['model'] ?>">
                    <button type="submit" name="editNews" class="btn btn-success pull-right" style="margin-left: 10px">
                        <?php echo __('Редактировать') ?>
                    </button>
                    <a href="<?php echo $params['url_site_admin'] ?>/<?php echo $params['module'] ?>/article" class="btn btn-danger pull-right">
                        <?php echo __('Отмена') ?>
                    </a>
                <?php } ?>
            </div>
        </div>

    </div>

</form>