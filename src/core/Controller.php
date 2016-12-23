<?php
namespace core;

abstract class Controller
{
    public function runAction($action)
    {
        $actionMethodName = 'action'.ucfirst($action);

        if(!method_exists($this,$actionMethodName)) {
            throw new Exception('Controller class '.get_class($this)
                .' dont have action '.$actionMethodName.'!');
        }

        return $this->{$actionMethodName}();
    }
}