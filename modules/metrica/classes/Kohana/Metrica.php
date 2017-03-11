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

        return new Metrica($params);
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

    public function pages($id = ''){

        $data = array();

        if(empty($id)){
            foreach($this->data['data'] as $k=>$value){

                $views = 0;
                foreach($value['metrics'][0] as $val) $views += $val;

                $visits = 0;
                foreach($value['metrics'][1] as $val) $visits += $val;

                $data[] = [
                    'page' => $value['dimensions'][0]['name'],
                    'views' => $views,
                    'visits' => $visits,
                    'id' => $value['dimensions'][0]['id']
                ];
            }

        }else{

            foreach($this->data['data'] as $k=>$value){

                $visits = [];
                $views = [];
                $date = [];

                if($id == $value['dimensions'][0]['id']){

                    foreach($value['metrics'][1] as $val) $visits[]  = $val;
                    foreach($value['metrics'][0] as $val) $views[] = $val;

                    foreach($this->data['time_intervals'] as $key=>$dates){
                        foreach($dates as $d) $date[] = $d;
                    }

                    $data = [
                        'page' => $value['dimensions'][0]['name'],
                        'visits' => $visits,
                        'views' => $views,
                        'date' => $date
                    ];
                }

            }



        }

        return $data;

    }

    public function gender(){

        $error = '';

        if(empty($this->data['data'])){
            $error = 'За выбранный период времени ничего не найдено';
        }

        if(empty($error)){

            $data = array();

            foreach($this->data['data'] as $key=>$value){
                foreach($value['dimensions'] as $val){
                    $i = 0;
                    foreach($val as $v){
                        if($i == 0) $data[$v] = $value['metrics'];
                        $i++;
                    }
                }
            }

            $gender_name = '';
            $gender_data = '';
            $num = 0;

            foreach($data as $key => $value){
                $total = 0;
                $gender_name .= "'".$key."',";
                foreach($value[0] as $t) $total += $t;

                $num += $total;

                if($total > 0) $gender_data .= "{value:".$total.", name:'".$key."'},";
            }

            if($num > 0) return $chart = array('name'=> $gender_name,'data'=>$gender_data);
            else return $error = 'За выбранный период времени ничего не найдено';

        }else{
            return $error;
        }
    }

    public function age(){

        $error = '';

        if(empty($this->data['data'])){
            $error = 'За выбранный период времени ничего не найдено';
        }

        if(empty($error)){
            $data = array();

            foreach($this->data['data'] as $key=>$value){
                foreach($value['dimensions'] as $val){
                    $i = 0;
                    foreach($val as $v){
                        if($i == 0) $data[$v] = $value['metrics'];
                        $i++;
                    }
                }
            }

            $age_name = '';
            $age_data = '';
            $num = 0;

            foreach($data as $key => $value){
                $total = 0;
                $age_name .= "'".$key."',";

                foreach($value[0] as $t) $total += $t;

                $num += $total;

                if($total > 0) $age_data .= "{value:".$total.", name:'".$key."'},";
            }

            if($num > 0) return $chart = array('name'=> $age_name,'data'=>$age_data);
            else return $error = 'За выбранный период времени ничего не найдено';

        }else{
            return $error;
        }

    }

    public function day_week(){

        $error = '';

        if(empty($this->data['data'])){
            $error = 'За выбранный период времени ничего не найдено';
        }

        if(empty($error)){

            $data = array();
            foreach($this->data['data'] as $v){
                $total = 0;
                foreach($v['metrics'][0] as $value){
                    if($value > 0){
                        $total += $value;
                    }
                }

                $data[$v['dimensions'][0]['name']] = $total;
            }

            $day_week_days = '';
            $day_week_data = '';

            foreach($data as $key=>$value){
                $day_week_days .= "'".$key."',";
                $day_week_data .= "{value:".$value.", name:'".$key."'},";
            }

            return $chart = array('days' => $day_week_days,'data'=>$day_week_data);

        }else{
            return $error;
        }
    }

    public function exemption(){

        $error = '';

        if(empty($this->data['data'])){
            $error = 'За выбранный период времени ничего не найдено';
        }

        if(empty($error)){

            $data = array();

            foreach($this->data['data'] as $key=>$value){
                foreach($value['dimensions'] as $val){
                    $i = 0;
                    foreach($val as $v){
                        if($i == 0) $data[$v] = $value['metrics'];
                        $i++;
                    }
                }
            }

            $exemption_name = '';
            $exemption_data = '';

            foreach($data as $key => $value){
                $total = 0;
                $k = '';
                if($key == 'no') $k = 'Без отказов';
                if($key == 'yes') $k = 'Отказы';

                $exemption_name .= "'$k',";
                foreach($value[0] as $t) $total += $t;


                $exemption_data .= "{value:".$total.", name:'".$k."'},";
            }

            return $chart = array('name'=> $exemption_name,'data'=>$exemption_data);
        }else{
            return $error;
        }
    }

}