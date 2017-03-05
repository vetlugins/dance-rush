<?php defined('SYSPATH') or die('No direct script access.');
/*
 * Если в настройках не указан период выборки, то по умолчанию статистика будет взята за последнии 6 дней
 *
 * Посещаемость. Ключи у методу visits($key,$charts=false): визиты => 0, посмотры =>1, посетители => 2.
 * Требуемые базовые метрики ym:s:visits,ym:s:pageviews,ym:s:users
 * где charts = данные сформированны для графика
 *
 * К базовым метрикам можно добавить выборку по полу, к статической функции factory($params) добавляем параметр в виде массива ['dimensions' => 'ym:s:gender']
 * Данная статистика вызывается методом gender($key,$gender,$charts=false), где $gender = ключ: 0 - женский, 1- мужской
 */
class Kohana_Metrica extends Kohana_MetricaRequest {


    public static function factory(array $params = array() ){

        return new Metrica($params = array());
    }

    public function visits($key,$charts=false){

        if(!$this->errors){

            $date = $this->data['time_intervals'] ?: [];
            $metrics = $this->data['data'][0]['metrics'][$key] ?: [];

            $data = array();

            foreach($date as $k=>$v){
                if(array_key_exists  ($k,$metrics)) {
                    if($k != 0) $data[$v[1]] = $metrics[$k];
                }
            }

            if($charts === true){

                $chart_date = '';
                $chart_data = '';

                foreach($data as $key=>$value){
                    $chart_date .= "'".$key."',";
                    $chart_data .= $value.",";
                }

                return $chart = array('date'=>$chart_date,'data'=>$chart_data);

            }

            return $data;

        }else{
            return $this->errors($this->errors);
        }
    }

    public function gender($key,$gender,$charts=false){

        if(!$this->errors){
            $date = $this->data['time_intervals'] ?: [];
            $dimensions = $this->data['data'][$gender]['dimensions'][0]['name'];
            $metrics = $this->data['data'][$gender]['metrics'][$key] ?: [];

            $data = array();

            foreach($date as $k=>$v){
                if(array_key_exists  ($k,$metrics)) {
                    if($k != 0) $data[$dimensions][] = [$v[1] => $metrics[$k]];
                }
            }

            if($charts === true){

                $female = $this->gender(0,0);
                $male = $this->gender(0,1);

                $gender = array_merge($female,$male);

                $gender_name = '';
                $gender_data = '';

                foreach($gender as $key=>$value){
                    $total = 0;
                    $gender_name .= "'".$key."',";
                    foreach($value as $val){
                        foreach($val as $v){
                            $total += $v;
                        }
                    }
                    $gender_data .= "{value:".$total.", name:'".$key."'},";
                }
                return $chart = array('name'=> $gender_name,'data'=>$gender_data);
            }

            return $data;
        }else{
            return $this->errors($this->errors);
        }
    }

}