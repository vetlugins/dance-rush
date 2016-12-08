<header class="navbar-fixed-top">
    <div class="container">
        <div class="col-md-4 p-1">
            <div class="logotype  col-md-4">
                <img src="<?php echo $params['theme'] ?>images/logotypes/logo-mini.png">
            </div>
            <div class="phone col-md-8">
                <h4 class="mt-1"><?php echo $params['config']['phone1'] ?></h4>
                <h4 class="mt-1"><?php echo $params['config']['phone2'] ?></h4>
            </div>
        </div>
        <div class="col-md-8">
            <ul class="nav navbar-nav mt-3 pull-right">
                <?php
                    if(isset($pages)) echo $pages['top'];
                ?>
            </ul>
        </div>
    </div>
</header>