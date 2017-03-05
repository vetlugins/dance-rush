<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-title">
                <i class="fa fa-book"></i>
                <h3><?php if(isset($album)) echo $album->title ?></h3>
                <div class="pull-right box-toolbar">
                    <a href="/admin/<?php echo $params['module'] ?>/upload?album=<?php if(isset($album)) echo $album->url ?>" class="btn btn-xs btn-primary">Загрузить фотографии</a>
                    <a href="/admin/<?php echo $params['module'] ?>" class="btn btn-xs btn-info">назад</a>
                </div>
            </div>
            <div class="box-body">
                <style>
                    .photo-cover-green{
                        border: 1px solid green;
                    }
                    .photo-cover-default{
                        border: 1px solid #ffffff;
                    }
                </style>
                <div class="photo-container">
                    <?php
                    if(isset($photos)){

                        foreach($photos as $photo){

                            if($photo->cover == 1) $cover = 'photo-cover-green';
                            else $cover = 'photo-cover-default';

                            echo '<div class="col-md-3 col-sm-4 col-xs-12">
                                    <div class="box '.$cover.'">
                                        <div class="box-body">
                                            <a href="/uploads/photo/original/'.$photo->image.'" class="fancybox " rel="gallery">
                                                <img src="/uploads/photo/small/'.$photo->image.'" class="thumb" style="height:160px; width:100%">
                                            </a>
                                        </div>
                                        <div class="box-footer">
                                            <a class="btn btn-xs btn-danger pull-right delete" title="Удалить" id="'.$photo->id.'" data-toggle="tooltip"><i class="fa fa-trash-o"></i></a>
                                            <a class="btn btn-xs btn-info pull-right margin-right-xs cover" title="Сделать обложкой" id="'.$photo->id.'" data-toggle="tooltip" rel="'.$album->url.'"><i class="fa fa-photo"></i></a>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                 </div>';

                        }

                    }
                    ?>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>