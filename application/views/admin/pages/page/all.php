<!-- СПИСОК ВСЕХ СТРАНИЦ САЙТА -->
<div class="row">
    <div class="col-md-12">
        <a href="/admin/pages/add" class="btn btn-success pull-right" style="margin-left: 10px">Добавить страницу</a>
    </div>
</div>
<div class="row margin-bottom-sm">
    <div class="col-md-12">
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
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="tab-content">
            <?php
            if(isset($items)){
                $i = 1;
                foreach($languages as $lang){

                    if($i == 1) $status = 'active';
                    else $status = '';

                    echo '<div class="tab-pane '.$status.'" id="'.$lang->i18n.'"><ul class="list-drag-n-drop no-margin no-padding">';
                           if(isset($items[$lang->i18n])) echo $items[$lang->i18n];
                    echo '</ul></div>';

                    $i++;
                }
            }else{
                echo '<div class="alert alert-info margin-top-sm margin-bottom-sm">Страниц на сайте еще нет</div>';
            }
            ?>
        </div>
    </div>
</div>