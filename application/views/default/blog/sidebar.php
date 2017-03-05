<?php
// Поиск по блогу
if(Params::obtain('block_search') == 1){
    echo '  <div class="panel panel-default no-border mb-2">
                <div class="panel-body">
                    <form role="form" action="'.$params['url_site'].'/search" method="get">
                        <label class="col-md-8  p-0">
                            <input name="s" placeholder="'. __('Какую статью хотим найти?').'" class="form-control">
                        </label>
                        <label class="col-md-4  pt-1">
                            <button type="submit" class="btn btn-outline-primary pull-right">'. __('Вперед').'!</button>
                        </label>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>';
}
// Категории
if(Params::obtain('block_category') == 1){

    echo '  <div class="panel panel-default no-border mt-2">
                <div class="panel-heading">
                    <h4>'.__('Категории').'</h4>
                </div>
                <div class="panel-body">
                    <ul class="category">';
                        if(isset($categories)){
                            foreach($categories as $category){
                                echo '<li>
                                                <a href="'.$params['url_site'].'/category/'.$category->url.'">
                                                    <i class="fa fa-chevron-right"></i>
                                                    '.$category->title.'
                                                    <span class="tag tag-pill tag-default pull-right" style="text-align: center">
                                                        '.$category->articles->where_soft()->count_all().'
                                                    </span>
                                                </a>
                                             </li>';
                            }
                        }
    echo '          </ul>
                </div>
            </div>';

}

if(Params::obtain('block_last_post') == 1){

    $active_popular = '';
    $active_random = '';

    if(Params::obtain('block_last_post_active') == 'popular') $active_popular = ' class="active"';
    if(Params::obtain('block_last_post_active') == 'random')  $active_random  = ' class="active"';

    echo ' <ul class="nav nav-tabs">
              <li '. $active_popular .'>
                <a class="nav-link " data-toggle="tab" href="#popular" role="tab">
                   '.__('Популярные').'
                </a>
              </li>
              <li '. $active_random .'>
                <a class="nav-link " data-toggle="tab" href="#random" role="tab">
                   '.__('Случайные').'
                </a>
              </li>
            </ul>';

    if(Params::obtain('block_last_post_active') == 'popular') $active_popular = 'in active';
    if(Params::obtain('block_last_post_active') == 'random')  $active_random  = 'in active';

    echo '  <div class="tab-content">
              <div id="popular" class="tab-pane fade '. $active_popular .' pt-1">';
                    if(isset($popular)){
                        foreach($popular as $pop){

                            $date = new DateFormat($pop->created_at);

                            echo '         <div class="article small">
                                                <div class="col-xs-4 image"><a href="/uploads/blog/slider/'.$pop->cover().'" class="fancybox"><img src="/uploads/blog/small/'.$pop->cover().'"></a></div>
                                                <div class="col-xs-8">
                                                    <h4><a href="'.$params['url_site'].'/'.$pop->url.'">'.$pop->title.'</a></h4>
                                                    <p class="date"><i class="fa fa-clock-o"></i> <span>'.$date->get_date(Params::obtain('date_format')).'</span></p>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>';

                        }
                    }
    echo '    </div>
              <div id="random" class="tab-pane fade '. $active_random .' pt-1">';
    if(isset($random)){
        foreach($random as $pop){

            $date = new DateFormat($pop->created_at);

            echo '                        <div class="article small">
                                                <div class="col-xs-4 image"><a href="/uploads/blog/slider/'.$pop->cover().'" class="fancybox"><img src="/uploads/blog/small/'.$pop->cover().'"></a></div>
                                                <div class="col-xs-8">
                                                    <h4><a href="'.$params['url_site'].'/'.$pop->url.'">'.$pop->title.'</a></h4>
                                                    <p class="date"><i class="fa fa-clock-o"></i> <span>'.$date->get_date(Params::obtain('date_format')).'</span></p>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>';

        }
    }
    echo '    </div>
            </div>';

}

if(Params::obtain('block_subscribe') == 1){
    if(Cookie::get('subscribe') != 1){

        echo '<div class="panel panel-default no-border mt-2">
                <div class="panel-heading"><h4>'.__('Подпишись на наши новости').'</h4></div>
                <div class="panel-body  p-0">

                    <form role="form" id="subscribe">
                        <label class="col-md-8  p-0">
                            <input type="email" name="email" placeholder="'. __('Ваш email адрес').'" class="form-control" required>
                        </label>
                        <label class="col-md-4  pt-1">
                            <button type="submit" class="btn btn-outline-primary pull-right">'.__('Вперед').'!</button>
                        </label>
                        <div class="clearfix"></div>
                    </form>

                    <div class="result_subscribe"></div>

                </div>
            </div>';

    }
}

if(Params::obtain('block_social_group') == 1){

    echo '<div class="panel panel-default no-border mt-2">
                <div class="panel-heading"><h4>'.__('Вступай в группу').'</h4></div>
                <div class="panel-body  p-0">';

                if(isset($social_group)){
                    foreach($social_group as $group){
                        echo '<div>'.$group->widget.'</div>';
                    }
                }

    echo '      </div>
            </div>';

}
