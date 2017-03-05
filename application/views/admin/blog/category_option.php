<?php
if(isset($item)){

    if(isset($item['current']) and $item['current'] == $item['url']) $current = 'selected';
    else $current = '';

    echo '<option value="'.$item['url'].'" '.$current.'>'.$item['dash'].' '.$item['title'].'</option>';
    if(isset($item['get_children']) and isset($item['parents']) and  count($item['parents']) > 0){
        echo $item['get_children'];
    }
}
