<?php if($config->get('posts') == true){ ?>
<div class="panel p-0">
    <div class="panel-body no-padding">
        <ul class="nav nav-tabs">
            <li<?php if($config->get('tab') == 'popular') echo ' class="active"' ?>><a href="#popular" data-toggle="tab"><?php echo __('Популярные') ?></a></li>
            <li<?php if($config->get('tab') == 'random') echo ' class="active"' ?>><a href="#random" data-toggle="tab"><?php echo __('Случайные') ?></a></li>
            <li<?php if($config->get('tab') == 'comments') echo ' class="active"' ?>><a href="#comments" data-toggle="tab"><?php echo __('Комментарии') ?></a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade <?php if($config->get('tab') == 'popular') echo ' in active"' ?>" id="popular">

                <?php
                if(isset($popular)){
                    foreach($popular as $pop){

                        $post = '';

                        if(!empty($pop->image)){
                            $post .= '<div class="col-xs-4 p-0 left"><img src="/uploads/news/small/'.$pop->image.'"></div>';
                            $width = 'col-xs-8';
                        }else{

                            $width = 'col-xs-12';

                            $videos = $pop->videos->find_all();
                            $i = 1;
                            foreach($videos as $v){

                                if($i == 1){
                                    if(!empty($v->image)) $post .= '<div class="col-xs-4 p-0 left"><img src="/uploads/video/'.$v->image.'"></div>';
                                    $width = 'col-xs-8';
                                }

                                $i++;
                            }


                        }

                        echo '<div class="aricle-small">
                                '.$post.'
                                <div class="'.$width.'">
                                    <h6><a href="'.$params['url_site'].'news/'.$pop->url.'">'.$pop->title.'</a></h6>
                                    <p class="date"><i class="fa fa-clock-o"></i> <span>18 ноября 2016</span></p>
                                </div>
                                <div class="clearfix"></div>
                            </div>';

                    }
                }
                ?>

            </div>
            <div class="tab-pane fade <?php if($config->get('tab') == 'random') echo ' in active"' ?>" id="random">

                <?php
                if(isset($random)){
                    foreach($random as $pop){

                        $post = '';

                        if(!empty($pop->image)){
                            $post .= '<div class="col-xs-4 p-0 left"><img src="/uploads/news/small/'.$pop->image.'"></div>';
                            $width = 'col-xs-8';
                        }else{

                            $width = 'col-xs-12';

                            $videos = $pop->videos->find_all();
                            $i = 1;
                            foreach($videos as $v){

                                if($i == 1){
                                    if(!empty($v->image)) $post .= '<div class="col-xs-4 p-0 left"><img src="/uploads/video/'.$v->image.'"></div>';
                                    $width = 'col-xs-8';
                                }

                                $i++;
                            }


                        }

                        echo '<div class="aricle-small">
                                '.$post.'
                                <div class="'.$width.'">
                                    <h6><a href="'.$params['url_site'].'news/'.$pop->url.'">'.$pop->title.'</a></h6>
                                    <p class="date"><i class="fa fa-clock-o"></i> <span>18 ноября 2016</span></p>
                                </div>
                                <div class="clearfix"></div>
                            </div>';

                    }
                }
                ?>

            </div>
            <div class="tab-pane fade <?php if($config->get('tab') == 'comments') echo ' in active"' ?> " id="comments">

                <?php
                if(isset($comments)){
                    foreach($comments as $comment){

                        echo '<div class="aricle-small">
                                <div class="col-xs-4 no-padding left"><img src="/uploads/users/dance_rush.jpg" class="img-circle"></div>
                                <div class="col-xs-8">
                                    <h6>Курбанов Азиз</h6>
                                    <p class="comment">'.$comment->comment.'</p>
                                    <p class="date">
                                        <i class="fa fa-clock-o"></i> <span>10 минут назад.</span>
                                        <span><a href="'.$params['url_site'].'news/'.$comment->news->url.'" data-toggle="tooltip" data-placement="top" title="'.$comment->news->title.'">'. __('Новость').'</a></span>
                                    </p>
                                </div>
                                <div class="clearfix"></div>
                            </div>';

                    }
                }
                ?>

            </div>
        </div>
    </div>
</div>
<?php } if($config->get('subscribe') == true){ ?>
<div class="panel p-0">
    <div class="panel-heading"><h5><?php echo __('Подпишись на наши новости') ?></h5></div>
    <div class="panel-body  p-0">

        <form role="form" class="subscribe">
            <label class="col-md-8  p-0">
                <input name="subscribe" placeholder="<?php echo __('Ваш email адрес') ?>" class="form-control">
            </label>
            <label class="col-md-4  p-0">
                <button type="submit" class="btn btn-outline-primary pull-right"><?php echo __('Вперед') ?>!</button>
            </label>
            <div class="clearfix"></div>
        </form>

    </div>
</div>
<?php } if($config->get('video') == true){ ?>
<div class="panel p-0">
    <div class="panel-heading"><h5><?php echo __('Видео') ?></h5></div>
    <div class="panel-body no-padding">

        <iframe src="//vk.com/video_ext.php?oid=-101210507&id=456239037&hash=96163796d53de9fa&sd" width="100%" height="240" frameborder="0" allowfullscreen></iframe>

    </div>
</div>
<?php } if($config->get('photo') == true){ ?>
<div class="panel">
    <div class="panel-heading"><h5><?php echo __('Фотографии') ?></h5></div>
    <div class="panel-body">
        <div class="slider-wrapper theme-default">
            <div id="slider" class="nivoSlider">
                <img src="/uploads/assets/slider_img1.jpg" data-thumb="/uploads/assets/slider_img1.jpg" alt="" />
                <img src="/uploads/assets/slider_img2.jpg" data-thumb="/uploads/assets/slider_img1.jpg" alt="" />
                <img src="/uploads/assets/slider_img3.jpg" data-thumb="/uploads/assets/slider_img1.jpg" alt="" />
            </div>
        </div>
    </div>
</div>
<?php } if($config->get('social_group') == true){ ?>
<div class="panel p-0">
    <div class="panel-heading"><h5><?php echo __('Вступай в группу') ?></h5></div>
    <div class="panel-body p-0">

        <?php

        if(isset($social_group)){
            foreach($social_group as $group){
                echo '<div>'.$group->widget.'</div>';
            }
        }

        ?>

    </div>
</div>
<?php }