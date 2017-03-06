<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-title">
                <i class="fa fa-film"></i>
                <h3><?php echo Kohana::message('admin', 'titles.'.$params['module'].'.all_item') ?></h3>
                <div class="pull-right box-toolbar">
                    <a href="/admin/<?php echo $params['module'] ?>/upload" class="btn btn-xs btn-primary">Загрузить</a>
                    <a class="btn btn-xs btn-success" data-toggle="modal" data-target="#addAlbum">Добавить альбом</a>
                </div>
            </div>
            <div class="box-body no-padding">
                <ul class="nav nav-tabs">
                    <?php
                    $i = 1;
                    foreach($languages as $lang){
                        if($i == 1) echo '<li class="active"><a href="#'.$lang->i18n.'" data-toggle="tab">'.$lang->label.'</a></li>';
                        else echo '<li><a href="#'.$lang->i18n.'" data-toggle="tab">'.$lang->label.'</a></li>';
                        $i++;
                    }
                    ?>
                </ul>
                <div class="tab-content table-responsive padding">
                    <?php
                    if(isset($items) and count($items)){
                        $i = 1;
                        foreach($languages as $lang){

                            if($i == 1) $status = ' active';
                            else $status = '';

                            echo '<div id="'.$lang->i18n.'" class="tab-pane'.$status.'">
                                    <ul class="list-drag-n-drop no-margin no-padding sortAlbum">';
                                    if(isset($items[$lang->i18n])) echo $items[$lang->i18n];
                            echo '  </ul>
                                 </div>';

                            $i++;
                        }
                    }else{
                        echo '<div class="alert alert-info margin-top-sm margin-bottom-sm">Альбомов на сайте еще нет</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addAlbum" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addVideoAlbum" class="form-horizontal" role="form">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Добавление альбома</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="lang" class="col-sm-3 control-label">Язык альбома</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="lang" id="lang">
                                <?php
                                foreach($languages as $lang){
                                    echo '<option value="'.$lang->i18n.'">'.$lang->label.'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="title" class="col-sm-3 control-label">Название</label>
                        <div class="col-sm-9">
                            <input type="text" name="title" class="form-control" id="title" placeholder="Название альбома" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="url" class="col-sm-3 control-label">URL</label>
                        <div class="col-sm-9">
                            <input type="text"  name="url" class="form-control" id="url" placeholder="URL альбома" required>
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
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Закрыть</button>
                        <input type="submit" class="btn btn-success" value="Добавить альбом">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editAlbum" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editVideoAlbum" class="form-horizontal" role="form">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Редактирование альбома</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit-lang" class="col-sm-3 control-label">Язык альбома</label>
                        <div class="col-sm-9">
                            <input type="text" name="lang" class="form-control" id="edit-lang" placeholder="Язык альбома" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit-title" class="col-sm-3 control-label">Название</label>
                        <div class="col-sm-9">
                            <input type="text" name="title" class="form-control" id="edit-title" placeholder="Название альбома" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit-url" class="col-sm-3 control-label">URL</label>
                        <div class="col-sm-9">
                            <input type="text" name="url" class="form-control" id="edit-url" placeholder="URL альбома" required>
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
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Закрыть</button>
                        <input type="submit" class="btn btn-success" value="Сохранить альбом">
                        <input type="hidden" class="form-control" id="edit-id" name="id">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>