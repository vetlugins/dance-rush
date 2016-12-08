<div class="row">

    <div class="col-md-12">
        <p class="alert alert-warning"><b>Внимание!</b> Данный раздел на стадии разработки</p>
    </div>

    <div class="col-md-6">
        <div class="box">
            <div class="box-title">
                <h3><i class="fa fa-gears"></i> Боковая панель</h3>
            </div>
            <div class="box-body padding-md">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="posts" class="col-sm-4 control-label">Вкладки со статьями</label>
                        <div class="col-sm-8">
                            <div class="checkbox">
                                <input type="checkbox" name="posts" id="posts" class="js-switch" <?php if($setting->posts == true) echo 'checked' ?>>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tab" class="col-sm-4 control-label">Активная вкладка</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="tab" id="tab">
                                <option value="random" <?php if($setting->tab == true) echo 'random'?>>Случайные статьи</option>
                                <option value="popular" <?php if($setting->tab == true) echo 'popular'?>>Популярные статьи</option>
                                <option value="comments" <?php if($setting->tab == true) echo 'comments'?>>Последнии комментарии</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="subscribe" class="col-sm-4 control-label">Разрешить подписку</label>
                        <div class="col-sm-8">
                            <div class="checkbox">
                                <input type="checkbox" name="subscribe" id="subscribe" class="js-switch_2" <?php if($setting->subscribe == true) echo 'checked' ?>>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="photo" class="col-sm-4 control-label">Слайдер фотографий</label>
                        <div class="col-sm-8">
                            <div class="checkbox">
                                <input type="checkbox" name="photo" id="photo" class="js-switch_3" <?php if($setting->photo == true) echo 'checked' ?>>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="video" class="col-sm-4 control-label">Слайдер видео</label>
                        <div class="col-sm-8">
                            <div class="checkbox">
                                <input type="checkbox" name="video" id="video" class="js-switch_4" <?php if($setting->video == true) echo 'checked' ?>>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="social_group" class="col-sm-4 control-label">Группы соц. сетей</label>
                        <div class="col-sm-8">
                            <div class="checkbox">
                                <input type="checkbox" name="social_group" id="social_group" class="js-switch_5" <?php if($setting->social_group == true) echo 'checked' ?>>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
                            <button type="submit" class="btn btn-success pull-right" name="setting_sidebar">Сохранить</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="box">
            <div class="box-title">
                <h3><i class="fa fa-gears"></i> Кэш</h3>
            </div>
            <div class="box-body padding-md">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="posts" class="col-sm-4 control-label">Очистить кэш раздела</label>
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-success pull-right" name="setting_clear_cache">Вперед</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="box">
            <div class="box-title">
                <h3><i class="fa fa-gears"></i> Посты</h3>
            </div>
            <div class="box-body padding-md">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="num" class="col-sm-4 control-label">Количество статей</label>
                        <div class="col-sm-8">
                            <input type="text" name="num" id="num" class="form-control" value="<?php echo $setting->num ?>">
                            <p class="help-block">Количество статей на страницу</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="date_format" class="col-sm-4 control-label">Формат времени</label>
                        <div class="col-sm-8">
                            <input type="text" name="date_format" id="date_format" class="form-control" value="<?php echo $setting->date_format ?>">
                            <p class="help-block">Другие <a href="#">форматы</a></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sort" class="col-sm-4 control-label">Сортировка</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="sort" id="sort">
                                <option value="DESC" <?php if($setting->sort == 'DESC') echo 'random'?>>Сначала новые</option>
                                <option value="null" <?php if($setting->sort == null) echo 'popular'?>>Сначала старые</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
                            <button type="submit" class="btn btn-success pull-right" name="setting_posts">Сохранить</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="box">
            <div class="box-title">
                <h3><i class="fa fa-gears"></i> Комментарии</h3>
            </div>
            <div class="box-body padding-md">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="comment" class="col-sm-4 control-label">Разрешить комментарии</label>
                        <div class="col-sm-8">
                            <div class="checkbox">
                                <input type="checkbox" name="comment" id="comment" class="js-switch_6" <?php if($setting->comment == true) echo 'checked' ?>>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="comment_flud" class="col-sm-4 control-label">Включить антифлуд</label>
                        <div class="col-sm-8">
                            <div class="checkbox">
                                <input type="checkbox" name="comment_flud" id="comment_flud" class="js-switch_7" <?php if($setting->comment_flud == true) echo 'checked' ?>>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="comment_flud_time" class="col-sm-4 control-label">Время ожидания</label>
                        <div class="col-sm-8">
                            <input type="text" value="<?php echo $setting->comment_flud_time ?>" name="comment_flud_time" class="form-control" id="comment_flud_time" placeholder="Время ожидания, в сек">
                            <p class="help-block">Время ожидания антифлуда указывается в секундах</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
                            <button type="submit" class="btn btn-success pull-right" name="setting_comments">Сохранить</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
