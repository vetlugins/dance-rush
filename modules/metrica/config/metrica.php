<?php defined('SYSPATH') or die('No direct script access.');

return array(
    /*
     * Номера счтечиков вводятся через запятую. Обязательный параметр. Должен быть указан, хотя бы один счетчик.
     */
    'ids'           => '159855',
    /*
     * Токен, выданный Яндексом, подробней http:// . Обязательный параметр.
     */
    'oauth_token'   => 'AQAAAAADkYurAAOaI9P6bBke6Uk7mlaGX7HmrWI',
    /*
     * Ссылка на api метрики. Обязательный параметр.
     */
    'api_url'       => 'https://api-metrika.yandex.ru/stat/v1/data/bytime',
    /*
    * Метрики, группировки и т.п. Не обязательные параметры
    */
    'metrics'       => 'ym:s:visits,ym:s:pageviews,ym:s:users',
    'dimensions'    => '',            // группировка
    'filters'       => '',            // фильтры. Фильтр для определенной страницы (ym:pv:URL=='http:ваш_сайт.рф/какой_путь')
    'date1'         => '',            // начало периода | по умолчанию 6dasAgo
    'date2'         => '',            // конец периода
    'pretty'        => 'true',        // по умолчанию false
    'group'         => 'day',         // группировка
    'sort'          => '',            // сортировка
    'selected_rows' => 'totals'
);