<section class="block min-height">

    <div class="container">

        <h1 class="text-center"><?php echo $album->title ?></h1>

        <div class="grid">
            <?php
            if(isset($album)){

                foreach($album->photos() as $photo){

                    echo '<figure class="col-md-3 grid-item">
                            <a href="/uploads/photo/original/'.$photo->image.'" class="photo fancybox " rel="gallery">
                                <img src="/uploads/photo/medium/'.$photo->image.'" >
                            </a>
                      </figure>';

                }

            }
            ?>
        </div>

        <div class="share p-1">
            <div class="pull-right">
                <script type="text/javascript">(function () {
                        if (window.pluso)if (typeof window.pluso.start == "function") return;
                        if (window.ifpluso == undefined) {
                            window.ifpluso = 1;
                            var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
                            s.type = 'text/javascript';
                            s.charset = 'UTF-8';
                            s.async = true;
                            s.src = ('https:' == window.location.protocol ? 'https' : 'http') + '://share.pluso.ru/pluso-like.js';
                            var h = d[g]('body')[0];
                            h.appendChild(s);
                        }
                    })();</script>
                <div class="pluso" data-background="transparent"
                     data-options="medium,round,line,horizontal,counter,theme=04"
                     data-services="vkontakte,odnoklassniki,facebook,twitter,google,moimir,email,print"></div>
            </div>
            <div class="clearfix"></div>
        </div>

    </div>

</section>
