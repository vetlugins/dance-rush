<?php
if(isset($posts)){

    foreach($posts as $post){

        $date = $post->created_at;
        $author = 'Курбанов Азиз';

        if(!empty($post->image)){
            $image = '<div class="col-md-4 pl-0">
                        <img src="/uploads/news/medium/'.$post->image.'">
                      </div>';
            $width = 'col-md-8';
        }else{
            $image = '';
            $width = 'col-md-12';
        }

        $video = '';
        $i = 1;
        $videos = $post->videos->where('deleted_at','=',null)->find_all();

        foreach($videos as $v){

            if(!empty($v->html)) $html_video = $v->html;
            else $html_video = '';

            if($i == 1){
                $video .= '<div class="col-md-12 pl-0">'.$html_video.'</div>';
            }elseif($i > 1 and $i <=4){
                $video .= '<div class="col-md-4 pl-0"><img src="'.$params['url_base'].'uploads/video/'.$v->image.'"></div>';
            }

            $i++;

        }



        echo '<div class="article">
                            '.$image.'
                            <div class="'.$width.' pl-0">
                                <h4><a href="'.$params['url_site'].'news/'.$post->url.'">'.$post->title.'</a></h4>
                                <div class="meta">
                                    <ul class="m-0 p-0">
                                        <li>'.__('Добавлено').': '.$date.'</li>
                                        <li>'.__('Автор').': '.$author.'</li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                '.$post->description.$video.'
                            </div>
                            <div class="clearfix"></div>
                        </div>';

    }

}