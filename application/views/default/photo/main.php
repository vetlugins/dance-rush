<section id="block" class="block min-height">
    <div class="container">
        <?php echo '<h2 class="section-title text-center">'.__('Наш цифровой мир').'</h2>'; ?>

        <?php
            if(isset($albums)){

                foreach($albums as $album){

                    echo '<figure class="col-md-3">
                            <a href="'.$params['url_site'].'/'.$album->url.'" class="photo album">
                                <img src="/uploads/photo/medium/'.$album->cover().'" >
                                <figcaption>
                                    <h4>'.$album->title.'</h4>
                                    <span>'.count($album->photos()).'</span>
                                </figcaption>
                            </a>
                          </figure>';

                }

            }
        ?>

    </div>
</section>