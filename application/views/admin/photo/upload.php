<div class="row">

    <div class="col-md-12">

        <?php if(isset($_GET['album'])){
            $album = ORM::factory('Photo_Album')->where('lang','=','ru')->where('url','=',$_GET['album'])->find();
        ?>

        <div class="box">
            <div class="box-title">
                <i class="fa fa-upload"></i> <h3>Загрузка фотографий в альбом <?php echo $album->title ?></h3>
            </div>
            <div class="box-body">
                <div id="dropzone">
                    <form  action="<?php echo $params['url_site_admin'] ?>/ajax/upload" class="dropzone" id="uploadPhoto" enctype="multipart/form-data">
                        <input type="hidden" name="album" value="<?php echo $_GET['album'] ?>">
                        <input type="hidden" name="uploadPhoto" value="uploadPhoto">
                    </form>
                </div>
            </div>
        </div>

            <div class="box">
                <div class="box-body">
                    <a href="<?php echo $params['url_site_admin'] ?>/photo/album/<?php echo $_GET['album'] ?>" class="btn btn-success btn-lg"  style="display: block; margin: 0 auto">Перейти к альбому "<?php echo $album->title ?>"</a>
                </div>
            </div>

        <?php }else{
            $albums = ORM::factory('Photo_Album')->where('lang','=','ru')->find_all();
        ?>

            <div class="box">
                <div class="box-title">
                    <i class="fa fa-upload"></i> <h3>Выберите альбом для загрузки фотографий</h3>
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
                                <input type="submit" class="btn btn-success" value="Загрузить фотографии">
                            </div>
                        </div>
                    </form>

                </div>
            </div>

        <?php } ?>

    </div>

</div>
