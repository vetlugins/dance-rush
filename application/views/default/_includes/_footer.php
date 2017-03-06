
<!-- footer -->
<section id="footer" class="fixed-bg" style="background-image: url('<?php echo  $params['url_base'] ?>uploads/system/assets/footer-bg.jpg')">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-12 text-center footer-info">
                <img src="/uploads/system/logo/<?php echo Params::obtain('footer_logo') ?>" alt="Logo">
            </div>
            <div class="col-md-9">
                <div class="col-md-4 col-sm-12 text-center footer-info">
                    <p><i class="icon icon-home"></i></p>
                    <p class="footer-text"><?php echo Params::obtain('address') ?></p>
                </div>
                <div class="col-md-4 col-sm-12 text-center footer-info">
                    <p><i class="icon icon-envelope-o"></i></p>
                    <p class="footer-text">
                        <a href="#"><?php echo Params::obtain('email') ?></a>
                        <a href="#"></a>
                    </p>
                </div>
                <div class="col-md-4 col-sm-12 text-center footer-info">
                    <p><i class="icon icon-tablet"></i></p>
                    <p class="footer-text">
                        <?php echo Params::obtain('phone1') ?>
                        <br>
                        <?php echo Params::obtain('phone2') ?>
                    </p>
                </div>
                <div class="clearfix mb-3"></div>
                <div class="text-center">
                    <h3 class="font-color-white"><?php echo Params::obtain('site_slogan') ?></h3>
                </div>
            </div>

        </div>
        <div class="row text-center">
            <div class="social affix-social">
                <a href="http://www.facebook.com"><i class="fa fa-facebook fa-2x"></i></a>
                <a href="http://www.google.com"><i class="fa fa-google fa-2x"></i></a>
                <a href="http://www.linkedin.com"><i class="fa fa-linkedin fa-2x"></i></a>
                <a href="http://www.pinterest.com"><i class="fa fa-pinterest fa-2x"></i></a>
                <a href="http://www.twitter.com"><i class="fa fa-twitter fa-2x"></i></a>
                <a href="http://www.rss.com"><i class="fa fa-rss fa-2x"></i></a>
                <a href="http://www.skype.com"><i class="fa fa-skype fa-2x"></i></a>
            </div>
        </div>
    </div>
</section>

<section id="copy-right">
    <div class="container">
        <div class="row text-center">
            <p>CopyRight &copy; 2015 - <?php echo date('Y').' '.Params::obtain('site_title') ?>. Сделано в  <a href="http://vetlugins.com">vetlugins.com</a></p>
        </div>
    </div>
</section>