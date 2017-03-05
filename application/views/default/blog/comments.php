<!-- comments -->
<div class="comments p-1" id="comments">

    <div class="panel">
        <div class="panel-heading">
            <h4>Комментарии <span class="tag tag-pill tag-default" style="text-align: center"><?php echo $count ?></span></h4>
        </div>
        <div class="panel-body">
            <div class="card card-block p-0" style="border: none;">
                <form id="formComments">
                    <?php
                    if(!Auth::instance()->get_user()){
                    ?>
                        <div class="form-group col-md-6 pl-0">
                            <label for="username">Ваше имя *</label>
                            <input type="text" name="name" class="form-control" id="username" placeholder="Например: Вася Пупкин" required>
                        </div>
                        <div class="form-group col-md-6 pr-0">
                            <label for="city">Откуда Вы (город)</label>
                            <input type="text" name="city" class="form-control" id="city" placeholder="Например: Москва">
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <label for="comment">Ваш комментарий *</label>
                        <textarea id="comment" name="comment" class="form-control" rows="7" required></textarea>
                    </div>
                    <div class="form-group col-md-6 pl-0">
                        <div class="g-recaptcha" data-sitekey="6LeSZgwUAAAAAADMXx27b0Ny6iehaTWpkqV972-v"></div>
                    </div>
                    <div class="form-group col-md-6 pr-0">
                        <label class="pull-right mt-1"><input type="submit" class="btn btn-outline-primary" value="Добавить"></label>
                    </div>
                    <input type="hidden" name="item_id" value="<?php echo $item['item_id'] ?>">
                    <input type="hidden" name="item_type" value="<?php echo $item['item_type'] ?>">
                </form>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>

    <div id="show_error"></div>
    <ul id="show_comments">
        <?php echo $show_comments ?>
    </ul>
    <?php if(isset($pagination)) echo $pagination; ?>
</div>