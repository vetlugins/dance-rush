<div class="col-md-12 col-lg-12 article">
    <div class="card no-shadow">
        <div class="card-block">
            <h4 class="card-title p-1 text-center" style="font-size: 28px"><?php echo $item['title'] ?></h4>
            <ul class="meta pr-1 pl-1 pb-2">
                <li><i class="icon icon-clock-o"></i> <?php echo $item['date'] ?></li>
                <li><i class="icon icon-star"></i> <?php echo $item['author'] ?></li>
                <?php if ($item['comment'] == true){ ?>
                    <li><i class="icon icon-bubbles"></i> 0</li>
                <?php }?>
                <li><i class="icon icon-eye"></i> <?php echo $item['views'] ?></li>
            </ul>
            <div class="clearfix"></div>
            <div class="card-text pl-1 pr-1 pb-1 border-bottom m-0 height-auto"><?php echo $item['description'] ?></div>
        </div>

        <div class="card-text m-0 height-auto pt-1">
            <div class="card-img height-auto no-border" style="width: 250px; float: left; margin: 0 10px 10px 0">
                <?php echo $item['image'] ?>
            </div>
            <?php echo $item['text'] ?>
        </div>
        <div class="clearfix"></div>
        <div class="share p-1">
            <div class="pull-left">
                <?php if ($item['comment'] == true){ ?>
                    <a href="#comments" class="btn btn-outline-primary go_comments">Комментировать</a>
                <?php }?>
            </div>
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
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="read-more p-0">
        <div class="panel">
            <div class="panel-heading"><h3>Читайте так же</h3></div>
            <div class="panel-body">
                <?php
                foreach ($read_more as $article) {

                    $date = new DateFormat($article->created_at);

                    echo '<div class="aricle-small">
                                <h4><a href="' . $params['url_site'] . '/' . $article->url . '">' . $article->title . '</a></h4>
                                <p class="date"><i class="fa fa-clock-o"></i> <span>' . $date->get_date(Params::obtain('date_format')) . '</span></p>
                            </div>';

                }
                ?>
            </div>
        </div>
    </div>

    <?php if ($item['comment'] === true) echo $comments;?>

    <div class="clearfix"></div>
</div>
<div class="col-md-4 col-lg-4">
    <?php if(isset($sidebar)) echo $sidebar; ?>
</div>