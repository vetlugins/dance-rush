<form id="formAddPage" class="form-horizontal" role="form" method="post">

    <div class="row">

        <div class="margin-bottom-sm">
            <div class="col-md-12">
                <?php if(!empty($alert)) echo $alert ?>
            </div>
        </div>

        <div class="col-md-12">
            <div class="box">
                <div class="box-title">
                    <i class="fa fa-sun-o"></i>
                    <h3>Язык и родитель страницы</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="lang" class="col-sm-2 control-label">Язык страницы</label>
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
                        <label for="parent_id" class="col-sm-2 control-label">Родитель</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="parent_id" id="parent_id">
                                <option value="0">Нет</option>
                                <?php if(isset($pages_option)) echo $pages_option; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="box">
                <div class="box-title">
                    <i class="fa fa-pencil"></i>
                    <h3>Содержимое страницы</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="title" class="col-sm-2 control-label">Название</label>
                        <div class="col-sm-10">
                            <input type="text" name="title" class="form-control" id="title" placeholder="Название страницы">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="url" class="col-sm-2 control-label">URL</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="url" placeholder="URL страницы" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="text">Содержимое</label>
                        <div class="col-sm-10">
                            <textarea name="text" id="text"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="box">
                <div class="box-title">
                    <i class="fa fa-signal"></i>
                    <h3>SEO - поисковая оптимизация страницы. Meta теги</h3>
                    <div class="pull-right box-toolbar">
                        <a href="#" class="btn btn-link btn-xs collapse-box"><i class="fa fa-chevron-down"></i></a>
                    </div>
                </div>
                <div class="box-body collapse">
                    <div class="form-group">
                        <label for="meta_title" class="col-sm-2 control-label">Название</label>
                        <div class="col-sm-10">
                            <input type="text" name="meta_title"  class="form-control" id="meta_title" placeholder="Название в заголовок браузера">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="meta_keyword" class="col-sm-2 control-label">Ключевые слова</label>
                        <div class="col-sm-10">
                            <input type="text" name="meta_keyword"  class="form-control" id="meta_keyword" placeholder="Ключевые слова">
                            <p class="help-block">Подробней о <a href="https://ru.wikipedia.org/wiki/%D0%9C%D0%B5%D1%82%D0%B0%D1%82%D0%B5%D0%B3%D0%B8#.D0.9C.D0.B5.D1.82.D0.B0.D1.82.D0.B5.D0.B3_Keywords" target="_blank">ключевых словах</a></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="meta_description" class="col-sm-2 control-label">Описание</label>
                        <div class="col-sm-10">
                            <input type="text" name="meta_description" class="form-control" id="meta_description" placeholder="Описание">
                            <p class="help-block">Подробней об <a href="https://ru.wikipedia.org/wiki/%D0%9C%D0%B5%D1%82%D0%B0%D1%82%D0%B5%D0%B3%D0%B8#.D0.9C.D0.B5.D1.82.D0.B0.D1.82.D0.B5.D0.B3_Description" target="_blank">описании</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="box">
                <div class="box-title">
                    <i class="fa fa-bookmark-o"></i>
                    <h3>Заголовки над меню</h3>
                    <div class="pull-right box-toolbar">
                        <a href="#" class="btn btn-link btn-xs collapse-box"><i class="fa fa-chevron-down"></i></a>
                    </div>
                </div>
                <div class="box-body collapse">
                    <div class="form-group">
                        <label for="icon" class="col-sm-2 control-label">Иконка</label>
                        <div class="col-sm-10">
                            <input type="text"  name="icon" class="form-control" id="icon" placeholder="Иконка">
                            <p class="help-block"><a href="<?php echo $params['url_site_admin'] ?>/extra/icons" target="_blank">Список доступных иконок</a>. fa-имя-иконки, вводится без fa</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sub" class="col-sm-2 control-label">Текст</label>
                        <div class="col-sm-10">
                            <input type="text" name="sub" class="form-control" id="sub" placeholder="Текст">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="box">
                <div class="box-title">
                    <i class="fa fa-cogs"></i>
                    <h3>Настройки</h3>
                    <div class="pull-right box-toolbar">
                        <a href="#" class="btn btn-link btn-xs collapse-box"><i class="fa fa-chevron-down"></i></a>
                    </div>
                </div>
                <div class="box-body collapse">
                    <div class="form-group">
                        <label for="target" class="col-sm-2 control-label">Метод открытия</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="target" id="target">
                                <option value="self">В текущем окне</option>
                                <option value="blank">В новой вкладке</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="redirect" class="col-sm-2 control-label">Переадресация</label>
                        <div class="col-sm-10">
                            <input type="text" name="redirect" class="form-control" id="redirect" placeholder="Переадресация">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="access" class="col-sm-2 control-label">Доступ</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="access" id="access">
                                <?php
                                if(isset($roles)){
                                    foreach($roles as $role){
                                        if(isset($page_array) and $page_array->access == $role->name){
                                            echo '<option value="'.$role->name.'" selected>'.$role->title.'</option>';
                                        }else{
                                            echo '<option value="'.$role->name.'">'.$role->title.'</option>';
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="view" class="col-sm-2 control-label">Видимость</label>
                        <div class="col-sm-10">
                            <input id="view" name="view" value="1" type="checkbox" class="js-switch" checked>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="margin-bottom-md">
            <div class="col-md-8">
            </div>
            <div class="col-md-4">
                <input type="hidden" name="updated"  value="<?php echo date('Y-m-d H:i:s') ?>">
                <input type="hidden" name="created"  value="<?php echo date('Y-m-d H:i:s') ?>">
                <input type="hidden" name="user_updated"  value="<?php echo Auth::instance()->get_user()->id ?>">
                <input type="hidden" name="user_created"  value="<?php echo Auth::instance()->get_user()->id ?>">
                <button type="submit" name="addPage" class="btn btn-success pull-right" style="margin-left: 10px">Добавить страницу</button> <a href="<?php echo $params['url_site_admin'] ?>/pages" class="btn btn-danger pull-right">Отмена</a>
            </div>
        </div>

    </div>

</form>
