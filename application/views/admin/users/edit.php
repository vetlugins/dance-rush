<?php
if(isset($id)) $action = $params['url_site_admin'].'/'.$params['module'].'/update';
else $action = $params['url_site_admin'].'/'.$params['module'].'/store';
?>
<form id="form" action="<?php echo $action ?>" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">

    <div class="row">

        <div class="margin-bottom-sm">
            <div class="col-md-8">
                <?php if(!empty($alert)) echo str_replace('validation.url.','',$alert) ?>
            </div>
            <div class="col-md-4">
                <?php
                if(!isset($id)){
                    ?>
                    <input type="hidden" name="updated_at"  value="<?php echo date('Y-m-d H:i:s') ?>">
                    <input type="hidden" name="user_updated"  value="<?php echo Auth::instance()->get_user()->id ?>">
                    <input type="hidden" name="user_created"  value="<?php echo Auth::instance()->get_user()->id ?>">
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
                    <button type="submit" name="editNews" class="btn btn-success pull-right" style="margin-left: 10px">
                        <?php echo __('Редактировать') ?>
                    </button>
                    <a href="<?php echo $params['url_site_admin'] ?>/<?php echo $params['module'] ?>/article" class="btn btn-danger pull-right">
                        <?php echo __('Отмена') ?>
                    </a>
                <?php } ?>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="col-md-8">
            <div class="box">
                <div class="box-title">
                    <i class="fa fa-user"></i>
                    <?php
                    if(isset($id) and !empty($item)){
                        echo '<h3>'.$item->username.'</h3>';
                    }else echo '<h3>'.__('Новый пользователь').'</h3>';
                    ?>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-md-4" for="username"><?php echo __('Имя пользователя') ?></label>
                        <div class="col-md-8"><input type="text" name="username" value="<?php if(isset($item)) echo $item->username ?>" id="username" class="form-control" required></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4" for="email"><?php echo __('Email') ?></label>
                        <div class="col-md-8"><input type="email" name="email" value="<?php if(isset($item)) echo $item->email ?>" id="email" class="form-control" <?php if(isset($item) and $item->email != '')echo 'disabled'; else echo 'required'; ?> ></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4" for="phone"><?php echo __('Телефон') ?></label>
                        <div class="col-md-8"><input type="text" name="phone" value="<?php if(isset($item)) echo $item->phone ?>" id="phone" class="form-control"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4" for="city"><?php echo __('Город') ?></label>
                        <div class="col-md-8"><input type="text" name="city" value="<?php if(isset($item)) echo $item->city ?>" id="city" class="form-control"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4" for="about"><?php echo __('О пользователе') ?></label>
                        <div class="col-md-8"><textarea name="about" id="about" class="form-control"><?php if(isset($item)) echo $item->about ?></textarea></div>
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


        <div class="margin-bottom-md">
            <div class="col-md-8">
            </div>
            <div class="col-md-4">

            </div>
        </div>

    </div>

</form>