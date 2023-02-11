<?php

class Router
{
    private $routes, $action, $params = [];

    public function __construct()
    {
        $this->routes = include(ROOT . '/app/config/routes.php');
    }

    public function run()
    {
        $uri = $_SERVER['REQUEST_URI'];
        foreach ($this->routes as $request => $response) {
            if(preg_match("/^\/($request)$/u", $uri)) {
                $str = preg_replace("/^\/($request)$/u", $response, $uri);
                $array = explode('/', $str);

                $nameController = array_shift($array).'Controller';
                $controller = 'app/controllers/'.$nameController;
                $this->action = 'Action' . array_shift($array);

                if (!empty($array)) {
                    $this->params[] = current($array);
                }
                include "$controller.php";

                call_user_func_array([new $nameController, $this->action], $this->params);
                break;
            }
        }

        if (!$this->action) {
            include 'app/controllers/BaseController.php';
            $error = new BaseController;
            exit($error->view->show('404'));
        }
    }
}