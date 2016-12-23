<?php
namespace core;

class Router
{
    private $_rules = [];

    /**
     * @var string
     */
    private $controllerName;

    /**
     * @var string
     */
    private $actionName;

    public function __construct($url,array $rules)
    {
        $this->setupRules($rules);
        $this->parseUrl($url);
    }

    protected function setupRules(array $rules)
    {
        $this->_rules = $rules;
    }

    public function getControllerName()
    {
        return $this->controllerName;
    }

    public function getActionName()
    {
        return $this->actionName;
    }

    private function getRules()
    {
        return $this->_rules;
    }

    private function parseUrl($url)
    {
        foreach ($this->getRules() as $params) {
            if ($url === $params['pattern']) {
                $this->setupParams($params);

                return;
            }
        }

        throw new \Exception('No rule available (404)');
    }

    private function setupParams($params)
    {
        $this->controllerName = $params['controller'];
        $this->actionName = $params['action'];
    }
}