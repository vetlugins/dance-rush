<form id="formAddNews" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">

    <div class="row">

        <div class="margin-bottom-sm">
            <div class="col-md-12">
                <?php if(!empty($alert)) echo $alert ?>
            </div>
        </div>

        <div class="col-md-12">
            <div class="box">
                <div class="box-title">
                    <i class="fa fa-pencil"></i>
                    <h3>Добавление новой статьи</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="lang" class="col-sm-2 control-label">Язык статьи</label>
                        <div class="col-sm-10">
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
                        <label for="title" class="col-sm-2 control-label">Название</label>
                        <div class="col-sm-10">
                            <input type="text" name="title" class="form-control" id="title" placeholder="Название статьи">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="url" class="col-sm-2 control-label">URL</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="url" placeholder="URL статьи" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="url" class="col-sm-2 control-label">Содержимое</label>
                        <div class="col-sm-10">
                            <ul class="nav nav-tabs" style="border-top: none ">
                                <li class="active"><a href="#news_description" data-toggle="tab"><label for="description">Краткое описание</label></a></li>
                                <li><a href="#news_text" data-toggle="tab"><label for="text">Полное содержание</label></a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="news_description">
                                    <textarea name="description" id="description"></textarea>
                                    <p class="help-block">Краткое описание статьи</p>
                                </div>
                                <div class="tab-pane" id="news_text">
                                    <textarea name="text" id="text"></textarea>
                                    <p class="help-block">Полное содержание статьи</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="box">
                <div class="box-title">
                    <i class="fa fa-photo"></i>
                    <h3>Обложка</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="image" class="col-sm-4 control-label">Выберите картинку</label>
                        <div class="col-sm-8">
                            <input type="file" name="image" class="btn btn-info file-inputs" title="Выберите картинку для обложки статьи">
                            <p class="help-block">Допустимые форматы: jpg, jpeg, png</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="box">
                <div class="box-title">
                    <i class="fa fa-eye"></i>
                    <h3>Видимость</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="view" class="col-sm-3 control-label">Опубликовать</label>
                        <div class="col-sm-9">
                            <input id="view" name="view" value="1" type="checkbox" class="js-switch" checked>
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
                <input type="hidden" name="updated_at"  value="<?php echo date('Y-m-d H:i:s') ?>">
                <input type="hidden" name="created_at"  value="<?php echo date('Y-m-d H:i:s') ?>">
                <input type="hidden" name="user_updated"  value="<?php echo Auth::instance()->get_user()->id ?>">
                <input type="hidden" name="user_created"  value="<?php echo Auth::instance()->get_user()->id ?>">
                <button type="submit" name="addNews" class="btn btn-success pull-right" style="margin-left: 10px">Добавить новость</button> <a href="<?php echo $params['url_site_admin'] ?>/<?php echo $params['module'] ?>" class="btn btn-danger pull-right">Отмена</a>
            </div>
        </div>

    </div>

</form>
