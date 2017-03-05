<header class="fixed" data-spy="affix" data-offset-top="2">
    <div class="container">
        <div class="col-md-2 col-xs-5 p-0">
            <div class="logotype">
                <a href="<?php echo URL::site() ?>"><img src="/uploads/system/logo/<?php echo  Params::obtain('general_logo') ?>"></a>
            </div>
        </div>
        <div class="col-md-10 col-xs-7 p-0">
            <nav class="navbar navbar-default text-center">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <?php if(isset($pages)) echo $pages; ?>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</header>