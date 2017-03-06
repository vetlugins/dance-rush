<?php
if(isset($posts)){

    foreach($posts as $post){

        $date = new DateFormat($post->created_at);
        $author = $post->author->username;

        $comment = '';

        if(Params::obtain('comments') == 1){
            if($post->comment == 1){
                $comment = ORM::factory('Comments')->count($post->id,'Blog');
                $comment = '<li><i class="icon icon-bubbles"></i> '.$comment.'</li>';
            }
        }

        if(isset($url_site)) $params['url_site'] = $url_site;

        echo '<div class="article col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-img">
                        <img class="card-img-top" src="/uploads/blog/medium/'.$post->cover().'" alt="'.$post->title.'">
                    </div>
                    <div class="card-block">
                        <h4 class="card-title p-1">'.$post->title.'</h4>
                        <ul class="meta pr-1 pl-1 pb-2">
                            <li><i class="icon icon-clock-o"></i> '.$date->get_date('d M Y H:i').'</li>
                            '.$comment.'
                            <li><i class="icon icon-eye"></i> '.$post->views.'</li>
                        </ul>
                        <div class="card-text pr-1 pl-1 pb-1">
                            '.$post->description.'
                        </div>
                        <div class="pr-1 pl-1 pb-1"><a href="'.$params['url_site'].'/'.$post->url.'">'.__('Подробней').'</a></div>
                    </div>
                </div>
              </div>';

    }

}