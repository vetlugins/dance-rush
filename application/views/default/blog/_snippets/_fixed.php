
<div class="col-lg-12 col-md-12 pb-2">
    <div id="carousel-news" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <?php
            if(isset($posts)){
                $i = 0;

                foreach($posts as $post){

                    if($i == 0) $current = ' class="active"';
                    else $current = '';

                    echo '<li data-target="#carousel-news" data-slide-to="'.$i.'" '.$current.'></li>';

                    $i++;
                }
            }
            ?>
        </ol>
        <div class="carousel-inner" role="listbox">
            <?php
            if(isset($posts)){
                $i = 0;

                foreach($posts as $post){

                    $date = new DateFormat($post->created_at);

                    if($i == 0) $current = 'active';
                    else $current = '';

                    echo '<div class="item '.$current.'">
                                <img src="/uploads/blog/slider/'.$post->cover().'" alt="'.$post->title.'">
                                  <div class="carousel-caption">
                                    <h3><a href="'.$params['url_site'].'/'.$post->url.'">'.$post->title.'</a></h3>
                                    <div class="meta">
                                        '.$date->get_date('d M Y H:i').'
                                    </div>
                                  </div>
                              </div>';

                    $i++;
                }
            }
            ?>
        </div>
        <a class="left carousel-control" href="#carousel-news" role="button" data-slide="prev">
            <span class="icon-prev" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#carousel-news" role="button" data-slide="next">
            <span class="icon-next" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>