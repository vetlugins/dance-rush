<div class="row">
  <div class="col-md-12">
    <div class="box">
      <div class="box-title">
        <i class="fa fa-superpowers"></i>
        <h3><?php echo __('Миграции') ?> - <?php echo __('Создание новой миграции') ?></h3>
        <div class="pull-right box-toolbar">
          <?php echo  HTML::anchor( Route::url('admin-administration-migrations') , __('Отмена'),['class' => 'btn btn-xs btn-danger']) ?>
        </div>
      </div>
      <div class="box-body no-padding">

        <form method="post" action="<?php echo URL::base().Route::get('migrations_create')->uri() ?>" role="form">

          <div class="col-md-12 margin-bottom-sm margin-top-sm no-padding">
            <div class="col-md-9">
              <?php
              $message = Session::instance()->get_once('message',false);
              if ($message) {
                echo $message;
              }else{
                echo '<div class="alert alert-info">'.__('Используйте только буквенно-цифровые символы и пробелы и не используйте зарезервированные слова php').'</div>';;
              }
              ?>
            </div>
            <div class="col-md-3">
              <?php echo  Form::submit('submit',__('Создать миграцию'),['class' => 'btn btn-success']) ?>
            </div>
            <div class="clearfix"></div>
          </div>

          <div class="col-md-12">
            <div class="form-group">
              <input type="text" class="form-control" id="migration_name" name="migration_name" placeholder="<?php echo __('Введите название миграции') ?>">
            </div>
          </div>


          <div class="clearfix"></div>

        </form>

      </div>
    </div>
  </div>
</div>