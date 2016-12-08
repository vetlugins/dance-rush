<div class="content container pt-1 pb-1">
    <div class="col-md-8 pl-0">

        <?php
            if(isset($posts)) echo $posts;
            if(isset($pagination)) echo $pagination;
        ?>

        <div class="clearfix"></div>

    </div>

    <div class="col-md-4 pr-0 pl-0">

        <?php
            if(isset($sidebar)) echo $sidebar;
        ?>

    </div>

    <div class="clearfix"></div>
</div>