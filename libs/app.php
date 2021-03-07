<?php
require_once 'controllers/errores.php';

class App {

    function __construct() {
        error_log('App::construct-> No hay controlador definido');
        $url = isset($_GET['url']) ? $_GET['url'] : null;
        $url = rtrim($url, '/');
        $url = explode('/', $url);

        if (empty($url[0])) {
            $fileController = 'controllers/login.php';
            require_once $fileController;
            $controller = new Login();
            $controller->loadModel('login');
            $controller->render();
            return false;
        }

        $fileController = 'controllers/' . $url[0] . '.php';

        if (file_exists($fileController)) {
            require_once $fileController;
            $controller = new $url[0];
            $controller->loadModel($url[0]);

            if (isset($url[1])) {
                if (method_exists($controller, $url[1])) {
                    if (isset($url[2])) {
                        $nparmas = count($url) - 2;

                        $params = [];

                        for ($i=0; $i < $nparmas; $i++) { 
                            array_push($params, $url[$i] + 2);
                        }

                        $controller->{$url[1]}($params);
                    } else {//no tiene parametros, se manda a llamar el metodo tal caul
                        $controller->{$url[1]}();
                    }
                } else { //Error, no existe el método
                    $controller = new Errores();
                    $controller->render();
                }
            } else { //No hay método a cargar, carga el método por default
                $controller->render();
            }
        } else {
            $controller = new Errores();
            $controller->render();
        }
    }

}