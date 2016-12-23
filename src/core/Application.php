<?php

namespace core;

class Application
{
    private function __construct()
    {

    }

    private static $_inst = null;

    public static function getInstance()
    {
        if(null === static::$_inst) {
            static::$_inst = new Application();
        }

        return static::$_inst;
    }

    final public function run()
    {
        $router = $this->createRouter();
        $controllerName = $router->getControllerName();
        $actionName = $router->getActionName();
        $this->runController($controllerName,$actionName);
    }

    protected function runController($controllerName,$actionName)
    {
        $contoller = $this->createController($controllerName);
        $contoller->runAction($actionName);
    }

    /**
     * Create controller by name
     * @example 'site' => SiteController
     * @example 'page' => PageController
     * @example 'product' => ProductController
     *
     * @param string $name controller name
     */
    protected function createController($name)
    {
        $controllerClass = 'controller\\'.ucfirst($name).'Controller';

        if(!class_exists($controllerClass)) {
            throw new \Exception('Controller class '.$controllerClass.' not exists!');
        }

        return new $controllerClass();
    }

    protected function createRouter()
    {
        $url = $_SERVER['REQUEST_URI'];

        /**
         * @todo: update conf mechanism
         */
        return new Router($url,
            require(
                static::getAppPath()
                .DIRECTORY_SEPARATOR.'config'
                .DIRECTORY_SEPARATOR.'routes.php')
        );
    }

    public static function getAppPath()
    {
        return dirname(getcwd());
    }

    private static $_session;

    /**
     * @return Session
     */
    public static function getSession()
    {
        if(null === static::$_session){
            static::$_session = new Session();
        }

        return static::$_session;
    }
}