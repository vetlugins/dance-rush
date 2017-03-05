<?php
if(isset($id)) $action = $params['url_site_admin'].'/'.$params['module'].'/update';
else $action = $params['url_site_admin'].'/'.$params['module'].'/store';
?>
<form id="formParams" action="<?php echo $action ?>" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">

    <div class="row">

        <div class="margin-bottom-sm">
            <div class="col-md-12">
                <?php if(!empty($alert)) echo str_replace('validation.url.','',$alert) ?>
            </div>
        </div>

        <div class="col-md-12">
            <div class="box">
                <div class="box-title">
                    <i class="fa fa-sun-o"></i>
                    <h3><?php echo !isset($id) ?  __('Добавление параметра') :  __('Редактирование параметра') ?></h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="section" class="col-sm-2 control-label"><?php echo __('Группа') ?></label>
                        <div class="col-sm-10">
                            <select class="form-control" name="section" id="section">
                                <?php
                                foreach($params['sections'] as $key=>$section){

                                    $selected = isset($id) && $id == $key ? 'selected': '';

                                    echo '<option value="'.$key.'" '.$selected.'>'.$section.'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label"><?php echo __('Идентификатор') ?></label>
                        <div class="col-sm-10">
                            <input type="text" value="<?php if(isset($item)) echo $item->name ?>" name="name" class="form-control" id="name" required <?php if(isset($id)) echo 'disabled' ?>>
                            <?php if(isset($id)) { ?><input type="hidden" value="<?php if(isset($item)) echo $item->name ?>" name="name" ><?php } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="title" class="col-sm-2 control-label"><?php echo __('Название') ?></label>
                        <div class="col-sm-10">
                            <input type="text" value="<?php if(isset($item)) echo $item->title ?>" name="title" class="form-control" id="title" required>
                        </div>
                    </div>

                    <?php if(!isset($id)){ ?>

                        <div class="form-group">
                            <label for="type" class="col-sm-2 control-label"><?php echo __('Тип') ?></label>
                            <div class="col-sm-10">
                                <select class="form-control" name="types" id="type">
                                    <option value="text"><?php echo __('Текстовый') ?></option>
                                    <option value="checkbox"><?php echo __('Чекбокс') ?></option>
                                    <option value="image"><?php echo __('Изображение') ?></option>
                                </select>
                            </div>
                        </div>

                        <div id="params_value">

                            <div class="form-group" id="text">
                                <label for="text1" class="col-sm-2 control-label"><?php echo __('Значение') ?></label>
                                <div class="col-sm-10">
                                    <input type="text" value="" name="value-text" class="form-control" id="text1">
                                </div>
                            </div>

                            <div class="form-group" id="checkbox">
                                <label for="checkbox1" class="col-sm-2 control-label"><?php echo __('Значение') ?></label>
                                <div class="col-sm-10">
                                    <input type="checkbox" name="value-checkbox" class="form-control js-switch" id="checkbox1" checked>
                                </div>
                            </div>

                            <div class="form-group" id="image">
                                <label for="image1" class="col-sm-2 control-label"><?php echo __('Значение') ?></label>
                                <div class="col-sm-10">
                                    <input type="file" name="value-image" class="btn btn-info file-inputs" id="image1"  title="<?php echo __('Выберите файл') ?>">
                                </div>
                            </div>

                            <input type="hidden" name="type" value="text">

                        </div>

                    <?php }else{ if(isset($item)){?>
                        <div class="form-group">
                            <label for="value" class="col-sm-2 control-label"><?php echo __('Значение') ?></label>
                            <div class="col-sm-10">
                                <?php
                                    switch($item->type){
                                        case 'text':
                                            echo '<input type="text" value="'.htmlspecialchars($item->value).'" name="value" class="form-control" id="value" required>';
                                            break;
                                        case 'checkbox':
                                            if($item->value == 1) $box_check = 'checked'; else $box_check = '';
                                            echo '<input type="checkbox" value="1" name="value" class="form-control js-switch" id="checkbox" '.$box_check.'>';
                                            break;
                                        case 'image':
                                            echo '<input type="file" name="value" class="btn btn-info file-inputs" id="image"  title="'.__('Выберите файл').'">';
                                            break;
                                    }
                                ?>
                                <input type="hidden" name="type" value="<?php echo $item->type ?>">
                            </div>
                        </div>
                    <?php }} ?>
                </div>
            </div>
        </div>

        <div class="margin-bottom-md">
            <div class="col-md-8">
            </div>
            <div class="col-md-4">
                <?php
                if(!isset($id)){
                    ?>
                    <button type="submit" class="btn btn-success pull-right" style="margin-left: 10px">
                        <?php echo __('Добавить') ?>
                    </button>
                    <a href="<?php echo $params['url_site_admin'] ?>/<?php echo $params['module'] ?>" class="btn btn-danger pull-right">
                        <?php echo __('Отмена') ?>
                    </a>
                <?php }else{ ?>
                    <button type="submit" class="btn btn-success pull-right" style="margin-left: 10px">
                        <?php echo __('Редактировать') ?>
                    </button>
                    <a href="<?php echo $params['url_site_admin'] ?>/<?php echo $params['module'] ?>" style="margin-left: 10px" class="btn btn-danger pull-right">
                        <?php echo __('Отмена') ?>
                    </a>
                <?php } ?>
            </div>
        </div>

    </div>

</form>