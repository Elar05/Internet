<?php

class Controller {

    function __construct() {
        $this->view = new View();
    }

    function loadModel($model) {
        $url = 'models/' . $model . 'Model.php';

        if (file_exists($url)) {
            require_once $url;

            $modelName = $model . 'Model';
            $this->model = new $modelName();
        }
    }

    function existsPost($params) {
        foreach ($params as $param) {
            if (!isset(($_POST[$param]))) {
                error_log('Controller::ExistsPost -> No existe el parametro' . $param);
                return false;
            }
        }
        return true;
    }

    function existsGet($params) {
        foreach ($params as $param) {
            if (!isset(($_GET[$param]))) {
                error_log('Controller::ExistsGet -> No existe el parametro' . $param);
                return false;
            }
        }
        return true;
    }

    function getGET($name) {
        return $_GET[$name];
    }

    function getPOST($name) {
        return $_POST[$name]
    }

    function redirect($route, $messages) {
        $data = [];
        $params = '';

        foreach ($messages as $message) {
            array_push($data, $key . '=' . $message);
        }
        $params = join('&', $data);

        if ($params != '') {
            $params = '?' . $params;
        }

        header('Location: ' . constant('URL') . $route . $params);
    }

}