<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-title">
                <i class="fa fa-users"></i>
                <h3><?php echo __('Список пользователей сайта') ?></h3>
                <div class="pull-right box-toolbar">
                    <a href="/admin/<?php echo $params['module'] ?>/add" class="btn btn-xs btn-success"><i class="fa fa-plus"></i> <?php echo __('Добавить') ?></a>
                </div>
            </div>
            <div class="box-body no-padding">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?php echo __('Имя пользователя') ?></th>
                            <th><?php echo __('Email') ?></th>
                            <th><?php echo __('Авторизаций') ?></th>
                            <th><?php echo __('Последняя авторизация') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($users)) echo $users ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>