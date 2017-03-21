<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-title">
                <i class="fa fa-superpowers"></i>
                <h3><?php echo __('Миграции') ?> - <?php echo __('Список миграций') ?></h3>
                <div class="pull-right box-toolbar">
                    <?php if (Kohana::$config->load('data.status') == 'local') echo  HTML::anchor( Route::get('migrations_new')->uri() , __('Создать новую миграцию'),['class' => 'btn btn-xs btn-success']) ?>
                </div>
            </div>
            <div class="box-body no-padding">

                <div class="col-md-12 no-padding">
                    <?php
                    $message = Session::instance()->get_once('message',false);
                    if ($message) {
                        echo '<div class="margin-bottom-sm" >'.$message.'</div>';
                    }
                    ?>
                </div>

                <table class="table table-hover table-striped" id="table-migration">
                    <thead>
                    <tr>
                        <th style="width: 3%"></th><th><?php echo __('Миграции') ?></th><th><?php echo __('Статус') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $i = 0;
                        foreach ($migrations as $key => $migration) {
                            $i++;
                    ?>
                        <tr>
                            <td class="text-center"><?php echo  $i; ?></td>
                            <td><?php echo  basename($migration, EXT); ?></td>
                            <td>
                                <?php   if ( array_key_exists(  substr(basename($migration, EXT), 0, 14) , $migrations_runned) ) { ?>
                                    <span class="btn btn-sm btn-success"><?php echo __('Завершено') ?></span>
                                <?php   } else { ?>
                                    <span class="btn btn-sm btn-warning"><?php echo __('Ожидает') ?></span>
                                <?php   }  ?>
                            </td>
                        </tr>
                    <?php  } ?>
                    </tbody>
                </table>

                <div class="col-md-5 col-md-offset-7 margin-bottom-sm">
                    <?php echo  HTML::anchor( Route::get('migrations_migrate')->uri() , __('ЗАПУСТИТЬ ВСЕ ОЖИДАЕМЫЕ МИГРАЦИИ'),['class' => 'btn btn-success']) ?>
                    <?php echo  HTML::anchor( Route::get('migrations_rollback')->uri() , __('ОТКАТИТЬ'),['class' => 'btn btn-danger']) ?>
                </div>

                <div class="clearfix"></div>

            </div>
        </div>
    </div>
</div>