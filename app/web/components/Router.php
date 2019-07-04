<?php


class Router
{
    private $routes;

    /**
     * Router constructor.
     */
    public function __construct()
    {
        $routesPath = ROOT . '/config/routes.php';
        $this->routes = include($routesPath);
    }

    /**
     * Get URI string
     * @return string
     */
    private function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    public function run()
    {
        //Получаем URI, который ввёл пользователь
        $uri = $this->getURI();

        //
        foreach ($this->routes as $uriPattern => $path) {
            //Сравниваем $uriPattern и $path
            if (preg_match("~$uriPattern~", $uri)) {

                //Получаем внутрений путь из указанного в URI, согласно правилу
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);

                //Определяем контроллер, action, параметры
                $segments = explode('/', $internalRoute);

                $controllerName = ucfirst(array_shift($segments) . 'Controller');

                $actionName = 'action' . ucfirst(array_shift($segments));

                $parameters = $segments;


                //Получаем файл класс-контроллера
                $controllerFile = ROOT . '/controllers/' . $controllerName . '.php';

                //Если файл существует, то подключаем его
                if (file_exists($controllerFile)) {
                    require_once($controllerFile);
                }

                //Создаём объект контроллера
                $controllerObject = new $controllerName;

                //Вызываем метод (action), передаём параметры
                $result = call_user_func_array(array($controllerObject, $actionName), $parameters);

                if ($result != null) {
                    break;
                }
            }
        }
    }
}