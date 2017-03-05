<div class="clearfix"></div>
<div class="<?php if(isset($pagination) and $pagination == 'comment') echo 'load-comment'; else echo 'load-news' ?> ">
    <div class="text-lg-center">
        <button class="btn btn-outline-primary" <?php if(isset($id)) echo 'id="'.$id.'"' ?>><img src="<?php echo $params['theme'] ?>images/loading2.gif"> Загрузить еще</button>
    </div>
</div>
<script>
    <?php
    if(isset($pagination) and $pagination == 'comment'){?>
    var news    = 10,
        ammount = 10;
    <?php }else{ ?>
    var news    = <?php echo $config->get('num') ?>,
        ammount = <?php echo $config->get('num') ?>;
    <?php } ?>
    <?php if(isset($category)) echo "var category = '".$category->url."';"; else echo "var category = '';" ?>
</script>