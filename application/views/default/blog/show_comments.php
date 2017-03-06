<div class="panel mt-2 mb-2">
    <div class="panel-heading dotted">
        <h5>
            <?php echo $comments['name'] ?>
            <span><?php if(!empty($comments['city'])) echo 'г. '.$comments['city'] ?></span>
            <!-- <span id="<?php echo $comments['id'] ?>" class="rating pull-right rating"><i class="fa fa-heart"></i> <b class="arrow_box"><?php echo $comments['rating'] ?></b></span> -->
            <span class="date pull-right"><i class="fa fa-clock-o"></i> <?php echo $comments['date'] ?></span>
        </h5>
    </div>
    <div class="panel-body">
        <div class="col-md-2 pl-0">
            <img src="<?php echo $comments['photo'] ?>">
        </div>
        <div class="col-md-10">
            <blockquote class="blockquote">
                <?php echo $comments['comment'] ?>
            </blockquote>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<div class="clearfix"></div>