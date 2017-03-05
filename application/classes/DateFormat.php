<?php
/**
 * Date Format 1.0
 *
 * @author     Ветлугин Александр
 * @copyright  (c) 2016 vetlugins.com
 * @license    http://vetlugins.com/license
 *
 * Данный класс не претендует на замену основной функции date(), но является неплохой его обверткой.
 * Класс работает как с текущей датой датой, так и с выбранной (дата вводится в формате UNIXTIME), так же есть возможность корректировать временную зону.
 *
 * Основной функцией класса, является get_date($type), который вы можете дополнить на свое усмотрение.
 *
 * Так же встроена функция fuzzy_span($timestamp, $local_timestamp = NULL) (позаимствованная у Kohana Team) - функция выводит дату в формате
 * "несколько секунд назад", "несколько минут назад" и т.д.
 *
 * Обратная функция timestamp($h = NULL,$i = NULL,$s = NULL,$m = NULL,$d = NULL,$y = NULL) выводит дату в формате UNIXTIME.
 *
 * Как это работает:
 * $date = new DateFormat($date = null,$utc = null); // где $date не обязательная переменная, в случае NULL будет отображена текущая дата
 *                                                   // $utc - временная зона. Например: Asia/Tashkent. Все временные зоны можно найти на http://php.net/
 * echo $date = get_date($type) // где $type шаблонный вариант для форматирования даты и времени
 */
class DateFormat
{

    public $day;
    public $month;
    public $year;
    public $hour_24;
    public $hour_12;
    public $minute;
    public $second;
    public $week;
    public $timezone;
    public $abbr_timezone;
    public $greenwich;
    public $AMPM;
    public $ampm;

    const YEAR = 31556926;
    const MONTH = 2629744;
    const WEEK = 604800;
    const DAY = 86400;
    const HOUR = 3600;
    const MINUTE = 60;

    private $month_format_full = array(
        '01' => 'января',
        '02' => 'февраля',
        '03' => 'марта',
        '04' => 'аперля',
        '05' => 'мая',
        '06' => 'июня',
        '07' => 'июля',
        '08' => 'августа',
        '09' => 'сентября',
        '10' => 'октября',
        '11' => 'ноября',
        '12' => 'декабря',
    );
    private $month_format_shot = array(
        '01' => 'янв',
        '02' => 'фев',
        '03' => 'март',
        '04' => 'апр',
        '05' => 'май',
        '06' => 'июнь',
        '07' => 'июль',
        '08' => 'авг',
        '09' => 'сен',
        '10' => 'окт',
        '11' => 'ноя',
        '12' => 'дек',
    );
    private $week_format_full = array(
        '0' => 'воскресенье',
        '1' => 'понедельник',
        '2' => 'вторник',
        '3' => 'среда',
        '4' => 'четверг',
        '5' => 'пятница',
        '6' => 'суббота'
    );

    public function __construct($date = null, $utc = null)
    {
        if ($utc !== null) date_default_timezone_set($utc);

        if($date === null){
            $this->day = date('d');
            $this->month = date('m');
            $this->year = date('Y');
            $this->hour_24 = date('H');
            $this->hour_14 = date('h');
            $this->minute = date('i');
            $this->second = date('s');
            $this->week = date('w');
            $this->timezone = date('e');
            $this->greenwich = date('P');
            $this->abbr_timezone = date('T');
            $this->AMPM = date('A');
            $this->ampm = date('a');
        }else{

            $datetime = explode(' ',$date);
            $date = explode('-',$datetime[0]);
            $time = explode(':',$datetime[1]);

            $timestamp = $this->timestamp($time[0],$time[1],$time[2],$date[1],$date[2],$date[0]);

            $this->day = date('d',$timestamp);
            $this->month = date('m',$timestamp);
            $this->year = date('Y',$timestamp);
            $this->hour_24 = date('H',$timestamp);
            $this->hour_14 = date('h',$timestamp);
            $this->minute = date('i',$timestamp);
            $this->second = date('s',$timestamp);
            $this->week = date('w',$timestamp);
            $this->timezone = date('e',$timestamp);
            $this->greenwich = date('P',$timestamp);
            $this->abbr_timezone = date('T',$timestamp);
            $this->AMPM = date('A',$timestamp);
            $this->ampm = date('a',$timestamp);
        }
    }

    public function month($format)
    {

        $month = '';

        switch ($format) {

            case 'full':
                foreach ($this->month_format_full as $key => $value) {

                    if ($key == $this->month) $month = $value;

                }
                break;
            case 'shot':
                foreach ($this->month_format_shot as $key => $value) {

                    if ($key == $this->month) $month = $value;

                }
                break;

        }

        return $month;

    }

    public function week()
    {

        $day_week = '';

        foreach ($this->week_format_full as $key => $value) {

            if ($key == $this->week) $day_week = $value;

        }

        return $day_week;
    }

    public function get_date($type)
    {

        $date = '';

        switch ($type) {
            case 'L, d F Y H:i:s UTC P T':
                $date = $this->week() . ', ' . $this->day . ' ' . $this->month('full') . ' ' . $this->year . ' ' . $this->hour_24 . ':' . $this->minute . ':' . $this->second . ' UTC ' . $this->greenwich . ' ' . $this->abbr_timezone;
                break;
            case 'd F Y': //где F полный формат месяца
                $date = $this->day . ' ' . $this->month('full') . ' ' . $this->year;
                break;
            case 'd M Y': //где M сокращенный формат месяца
                $date = $this->day . ' ' . $this->month('shot') . ' ' . $this->year;
                break;
            case 'd m Y': //где m числовой формат месяца
                $date = $this->day . ' ' . $this->month . ' ' . $this->year;
                break;
            case 'd.m.Y':
                $date = $this->day . '.' . $this->month . '.' . $this->year;
                break;
            case 'd/m/Y':
                $date = $this->day . '/' . $this->month . '/' . $this->year;
                break;
            case 'Y-m-d':
                $date = $this->year . '-' . $this->month . '-' . $this->day;
                break;
            case 'L, d F Y': //где L полное наимнование недели
                $date = $this->week() . ', ' . $this->day . ' ' . $this->month('full') . ' ' . $this->year;
                break;
            case 'd.F.Y в H:i':
                $date = $this->day . ' ' . $this->month('full') . ' ' . $this->year . ' в ' . $this->hour_24 . ':' . $this->minute;
                break;
            case 'd M Y H:i':
                $date = $this->day . ' ' . $this->month('shot') . ' ' . $this->year . ' ' . $this->hour_24 . ':' . $this->minute;
                break;
        }

        return $date;

    }

    public static function fuzzy_span($timestamp, $local_timestamp = NULL)
    {
        $local_timestamp = ($local_timestamp === NULL) ? time() : (int)$local_timestamp;

        // Determine the difference in seconds
        $offset = abs($local_timestamp - $timestamp);

        if ($offset <= DateFormat::MINUTE) {
            $span = 'несколько секунд';
        } elseif ($offset < (DateFormat::MINUTE * 20)) {
            $span = 'несколько минут';
        } elseif ($offset < DateFormat::HOUR) {
            $span = 'меньше часа';
        } elseif ($offset < (DateFormat::HOUR * 4)) {
            $span = 'пару часов';
        } elseif ($offset < DateFormat::DAY) {
            $span = 'меньше дня';
        } elseif ($offset < (DateFormat::DAY * 2)) {
            $span = 'около суток';
        } elseif ($offset < (DateFormat::DAY * 4)) {
            $span = 'несколько дней';
        } elseif ($offset < DateFormat::WEEK) {
            $span = 'меньше недели';
        } elseif ($offset < (DateFormat::WEEK * 2)) {
            $span = 'около недели';
        } elseif ($offset < DateFormat::MONTH) {
            $span = 'меньше месяца';
        } elseif ($offset < (DateFormat::MONTH * 2)) {
            $span = 'около месяца';
        } elseif ($offset < (DateFormat::MONTH * 4)) {
            $span = 'несколько месяцев';
        } elseif ($offset < DateFormat::YEAR) {
            $span = 'меньше года';
        } elseif ($offset < (DateFormat::YEAR * 2)) {
            $span = 'около года';
        } elseif ($offset < (DateFormat::YEAR * 4)) {
            $span = 'пару лет';
        } elseif ($offset < (DateFormat::YEAR * 8)) {
            $span = 'несколько лет';
        } elseif ($offset < (DateFormat::YEAR * 12)) {
            $span = 'около десяти лет';
        } elseif ($offset < (DateFormat::YEAR * 24)) {
            $span = 'пару десятилетий ';
        } elseif ($offset < (DateFormat::YEAR * 64)) {
            $span = 'несколько десятилетий';
        } else {
            $span = 'очееень давно';
        }

        if ($timestamp <= $local_timestamp) {
            // This is in the past
            return $span . ' назад';
        } else {
            // This in the future
            return $span;
        }
    }

    public function timestamp($h = NULL, $i = NULL, $s = NULL, $m = NULL, $d = NULL, $y = NULL)
    {

        if ($d === NULL) $d = 0;
        if ($m === NULL) $m = 0;
        if ($y === NULL) $y = 0;
        if ($h === NULL) $h = 0;
        if ($i === NULL) $i = 0;
        if ($s === NULL) $s = 0;


        $timestamp = mktime($h, $i, $s, $m, $d, $y);

        return $timestamp;
    }
}