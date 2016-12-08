<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-title">
                <h3>
                    <i class="fa fa-book"></i>
                    Фотоальбомы
                </h3>
            </div>
            <div class="box-body">
                <?php
                if(isset($items)){
                    if(isset($items)) echo $items;
                }else{
                    echo '<div class="alert alert-info margin-top-sm margin-bottom-sm">Фотоальбомов на сайте еще нет</div>';
                }
                ?>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
