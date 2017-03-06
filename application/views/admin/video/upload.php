<div class="row">
    <div class="margin-bottom-sm">
        <div class="col-md-12">
            <?php if(!empty($alert)) echo str_replace('validation.url.','',$alert) ?>
        </div>
    </div>
    <div class="col-md-12">

        <?php if(isset($_GET['album'])){
            $album = ORM::factory($params['model'])->where('lang','=','ru')->where('url','=',$_GET['album'])->find();
        ?>



        <div class="box">
            <div class="box-title">
                <i class="fa fa-upload"></i> <h3><?php echo Kohana::message('admin', 'titles.'.$params['module'].'.upload_in_album') ?> <?php echo $album->title ?></h3>
            </div>
            <div class="box-body">
                <form id="formUploadVideo" action="<?php echo $params['url_site_admin'].'/'.$params['module'].'/store' ?>" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="service" class="col-sm-2 control-label"><?php echo Kohana::message('admin', 'fields.'.$params['module'].'.service') ?></label>
                        <div class="col-sm-10">
                            <select class="form-control" name="service" id="service">
                                <option><?php echo Kohana::message('admin', 'fields.'.$params['module'].'.select_hosting') ?></option>
                                <option value="youtube">YouTube</option>
                                <option value="vimeo">Vimeo</option>
                                <option value="rutube">RuTube</option>
                                <option value="vk">В контакте</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="url" class="col-sm-2 control-label"><?php echo Kohana::message('admin', 'fields.'.$params['module'].'.url_video') ?></label>
                        <div class="col-sm-10">
                            <input type="text" id="url" name="url" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="image" class="col-sm-2 control-label"><?php echo Kohana::message('admin', 'fields.'.$params['module'].'.image_video') ?></label>
                        <div class="col-sm-10">
                            <input type="file" id="image" name="image"  class="btn btn-info file-inputs" title="<?php echo Kohana::message('admin', 'button.select') ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="html" class="col-sm-2 control-label"><?php echo Kohana::message('admin', 'fields.'.$params['module'].'.html_video') ?></label>
                        <div class="col-sm-10">
                            <textarea name="html" id="html" rows="5" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="margin-bottom-md">
                        <div class="col-md-8">
                        </div>
                        <div class="col-md-4">
                            <input type="hidden" name="album_id"  value="<?php echo $album->id ?>">
                            <input type="hidden" name="album_url"  value="<?php echo $album->url ?>">
                            <input type="hidden" name="user_created"  value="<?php echo Auth::instance()->get_user()->id ?>">
                            <button type="submit" name="editNews" class="btn btn-success pull-right" style="margin-left: 10px">
                                <?php echo Kohana::message('admin', 'button.upload') ?>
                            </button>
                            <a href="<?php echo $params['url_site_admin'] ?>/<?php echo $params['module'] ?>" class="btn btn-danger pull-right">
                                <?php echo Kohana::message('admin', 'button.cancel') ?>
                            </a>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                </form>
            </div>
        </div>

        <?php }else{
            $albums = ORM::factory($params['model'])->albums('ru');
        ?>

            <div class="box">
                <div class="box-title">
                    <i class="fa fa-upload"></i> <h3><?php echo Kohana::message('admin', 'titles.'.$params['module'].'.choose_album') ?></h3>
                </div>
                <div class="box-body" style="min-height: 300px">

                    <form method="get" class="form-horizontal" role="form">
                        <div class="col-sm-12" style="margin: 100px auto">
                            <div class="col-sm-10">
                                <select class="form-control" name="album" id="album">
                                    <?php
                                    foreach($albums as $album){
                                        echo '<option value="'.$album->url.'">'.$album->title.'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <input type="submit" class="btn btn-success" value="<?php echo Kohana::message('admin', 'button.upload') ?>">
                            </div>
                        </div>
                    </form>

                </div>
            </div>

        <?php } ?>

    </div>

</div>
