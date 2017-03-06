<?php defined('SYSPATH') or die('No direct script access.');

class Kohana_MetricaRequest {

    public $errors = [];
    public $url;
    public $data;
    public $format;
    public $params = [];

    public function __construct($params = array()){

        $this->params = $this->setParams($params);

        if($this->params['ids'] and $this->params['oauth_token'] and $this->params['api_url']){

            $this->setUrl();

            $this->data = $this->get_data();

            if(!$this->data){
                $this->errors = $this->data['errors'];
            }

        }else{
            $this->errors = [
                [
                    ['error_type' => 'empty_parameter'],
                    ['message' => 'Не указанны основные параметры в конфигурации модуля Metrica']
                ]
            ];
        }
    }

    private function setUrl(){

        $this->url = $this->params['api_url'].$this->format.'?';
        foreach($this->params as $key=>$value){
            if($key != 'api_url'){
                $this->url .= '&'.$key.'='.$value;
            }
        }

        return $this->url;

    }

    private function get_data()
    {
        if($this->url){

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $data = json_decode(
                curl_exec($ch), true
            );

            curl_close($ch);

            if(is_array($data)){

                return $data;
            }
        }

        return false;
    }

    private function setParams(array $params){

        $all_params = [];

        $general = Kohana::$config->load('metrica');

        foreach($general as $key => $value){
            if(!empty($value)){
                $all_params[$key] = $value;
            }
        }

        if($params) $all_params = array_merge($all_params,$params);

        return $all_params;

    }

}