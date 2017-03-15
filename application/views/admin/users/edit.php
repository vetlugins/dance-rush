<?php
if(isset($id)) $action = $params['url_site_admin'].'/'.$params['module'].'/update';
else $action = $params['url_site_admin'].'/'.$params['module'].'/store';

?>
<form id="formUser" action="<?php echo $action ?>" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">

    <div class="row">

        <div class="margin-bottom-sm">
            <div class="col-md-8">
                <?php if(!empty($alert)) echo str_replace('validation.url.','',$alert) ?>
            </div>
            <div class="col-md-4">
                <?php if(!isset($id) and !isset($item)){ ?>
                    <button type="submit" name="addUser" class="btn btn-success pull-right" style="margin-left: 10px">
                        <?php echo __('Добавить') ?>
                    </button>
                    <a href="<?php echo $params['url_site_admin'] ?>/<?php echo $params['module'] ?>" class="btn btn-danger pull-right">
                        <?php echo __('Отмена') ?>
                    </a>
                <?php }else{ ?>
                    <input type="hidden" name="login" value="<?php echo $item->login ?>">
                    <button type="submit" name="editUser" class="btn btn-success pull-right" style="margin-left: 10px">
                        <?php echo __('Редактировать') ?>
                    </button>
                    <a href="<?php echo $params['url_site_admin'] ?>/<?php echo $params['module'] ?>" class="btn btn-danger pull-right">
                        <?php echo __('Отмена') ?>
                    </a>
                <?php } ?>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="col-md-8">
            <div class="box">
                <div class="box-title">
                    <i class="fa fa-address-card-o"></i>
                    <?php
                    if(isset($id) and !empty($item)){
                        echo '<h3>'.$item->username.'</h3>';
                    }else echo '<h3>'.__('Новый пользователь').'</h3>';
                    ?>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="login"><?php echo __('Логин') ?></label>
                        <div class="col-md-9"><input type="text" name="login" value="<?php if(isset($item)) echo $item->login ?>" id="login" class="form-control" <?php if(isset($item) and $item->login != '')echo 'disabled'; else echo 'required'; ?>></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="username"><?php echo __('Имя пользователя') ?></label>
                        <div class="col-md-9"><input type="text" name="username" value="<?php if(isset($item)) echo $item->username ?>" id="username" class="form-control" required></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="email"><?php echo __('Email') ?></label>
                        <div class="col-md-9"><input type="email" name="email" value="<?php if(isset($item)) echo $item->email ?>" id="email" class="form-control" <?php if(isset($item) and $item->email != '')echo 'disabled'; else echo 'required'; ?> ></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="phone"><?php echo __('Телефон') ?></label>
                        <div class="col-md-9"><input type="text" name="phone" data-inputmask="'mask': '+7(999)999-99-99'" value="<?php if(isset($item)) echo $item->phone ?>" id="phone" class="form-control"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="city"><?php echo __('Город') ?></label>
                        <div class="col-md-9"><input type="text" name="city" value="<?php if(isset($item)) echo $item->city ?>" id="city" class="form-control"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="about"><?php echo __('О пользователе') ?></label>
                        <div class="col-md-9"><textarea name="about" id="about" class="form-control"><?php if(isset($item)) echo $item->about ?></textarea></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="role"><?php echo __('Роль') ?></label>
                        <div class="col-md-9">
                            <select id="role" name="role[]" multiple class="multiple-roles form-control" required>
                                <?php
                                    foreach($roles as $role){
                                        if(!isset($id)){
                                            if($role->id == 1) echo '<option value="'.$role->id.'" selected>'.$role->title.'</option>';
                                            else echo '<option value="'.$role->id.'">'.$role->title.'</option>';
                                        }else{
                                            if(array_key_exists($role->id,$user_roles)) echo '<option value="'.$role->id.'" selected>'.$role->title.'</option>';
                                            else echo '<option value="'.$role->id.'">'.$role->title.'</option>';
                                        }
                                    }
                                ?>
                            </select>
                            <p class="help-block"><?php echo __('Если роль будет "Администрация", то так же нужно выбрать роль "Авторизированные"') ?></p>
                            <p class="help-block"><?php echo __('Если необходимо забанить пользователя выберите роль "Забаненные"') ?></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="password"><?php echo __('Пароль') ?></label>
                        <div class="col-md-9"><input type="password" name="password" id="password"  class="form-control" <?php if(!isset($item))echo 'required'; ?> ></div>
                    </div>
                </div>
            </div>

            <?php if(isset($id)){ ?>
            <div class="box">
                <div class="box-title">
                    <i class="fa fa-signal"></i>
                    <h3><?php echo __('Активность пользователя') ?></h3>
                </div>
                <div class="box-body no-padding">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#actions" data-toggle="tab"><?php echo __('Действия') ?></a></li>
                        <li><a href="#authorization" data-toggle="tab"><?php echo __('Авторизации') ?></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active padding" id="actions">
                            <div class="alert alert-info"><?php echo __('Данный раздел на стадии разаработки') ?></div>
                        </div>
                        <div class="tab-pane" id="authorization">
                            <table id="visits" class="table table-hover table-striped">
                                <thead>
                                <tr>
                                    <th>№</th>
                                    <th>IP</th>
                                    <th>Дата</th>
                                    <th>Браузер</th>
                                    <th>ОС</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(isset($visits)){
                                    $i = 1;
                                    foreach($visits as $visit){
                                        echo '<tr>
                                                <td>'.$i.'</td>
                                                <td>'.$visit['ip'].'</td>
                                                <td>'.$visit['date'].'</td>
                                                <td>'.$visit['browser'].' '.$visit['browserVersion'].'</td>
                                                <td>'.$visit['platform'].'</td>
                                              </tr>';

                                        $i++;
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
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
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse3"><?php echo __('Фотография') ?></a>
                                    </h4>
                                </div>
                                <div id="collapse3" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label for="image"></label>
                                            <div class="col-sm-12 text-center">
                                                <?php
                                                if(isset($item) and !empty($item->cover())){
                                                    ?>
                                                    <p>
                                                        <a href="/uploads/<?php echo $params['module'] ?>/original/<?php echo $item->cover() ?>" class="fancybox"><img src="/uploads/<?php echo $params['module'] ?>/small/<?php echo $item->cover() ?>" class="img-thumbnail"></a>
                                                    </p>
                                                <?php }else{ ?>
                                                    <p><img src="/uploads/users/no_avatar.jpg" alt="" style="width: 100%"></p>
                                                    <p class="alert alert-info">
                                                        <?php echo __('Фотография отсутствует') ?>
                                                    </p>
                                                <?php } ?>

                                                <input type="file" name="image" class="btn btn-info file-inputs" title="<?php echo __('Выберите файл') ?>">
                                                <p class="help-block"><?php echo __('Допустимые форматы') ?>: jpg, jpeg, png</p>

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

    </div>

</form>