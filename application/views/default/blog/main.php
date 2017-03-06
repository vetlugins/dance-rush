<section id="block" class="block min-height">
    <div class="container">
        <?php if(!isset($show_article)) echo '<h2 class="section-title text-center">'.__('Наши события').'</h2>'; ?>
        <div class="col-md-8">
            <?php if(!empty($article_fixed)) echo $article_fixed; ?>
            <?php if(isset($article) and count($article)) echo $article; else echo '<div class="alert alert-info">'.__('Статей здесь еще нет').'</div>'; ?>
        </div>
        <div class="col-md-4">
            <?php include 'sidebar.php' ?>
        </div>
    </div>
</section>