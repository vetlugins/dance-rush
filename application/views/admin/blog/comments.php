<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-title">
                <i class="fa fa-book"></i>
                <h3><?php echo Kohana::message('admin', 'titles.'.$params['module'].'.all_item.comments') ?></h3>
            </div>
            <div class="box-body no-padding">
                <?php
                if(isset($items)){
                    echo '<table class="table table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center" style="width:2%">#</th>
                                    <th style="width:35%">Комментарий</th>
                                    <th style="width:25%">Статья</th>
                                    <th style="width:15%">Дата отправки</th>
                                    <th style="width:15%">Автор</th>
                                    <th style="width:10%">'.Kohana::message('admin', 'fields.'.$params['module'].'.action').'</th>
                                </tr>
                                </thead>
                                <tbody class="list-drag-n-drop">'.$items.'</tbody>
                          </table>';
                }else{
                    echo '<div class="alert alert-info margin-top-sm margin-bottom-sm">'.Kohana::message('admin', 'alert.info.no_items').'</div>';
                }
                ?>
            </div>
        </div>
    </div>
</div>