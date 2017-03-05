<p>Пользователь <b><?php echo $item['name'] ?></b> <?php if(!empty($item['city'])) echo 'г. '.$item['city'] ?> оставил комментарий!</p>
<p>Статья: <b><?php echo $item['article'] ?></b></p>
<p>Комментарий:</p>
<div style="padding: 30px">
    <?php echo $item['comment'] ?>
</div>
<p>Дата отправки: <b><?php echo $item['date'] ?></b></p>