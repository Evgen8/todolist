<?php
namespace core;


class Session
{
    const SESSION_ID_KEY = 'session_key';
    const SESSION_NAME_KEY = 'session_name';

    public function __construct()
    {
        session_start();
    }

    public function isLoginned()
    {
        if(null !== $this->{static::SESSION_ID_KEY}
        && '' !== $this->{static::SESSION_ID_KEY}) {
            return true;
        }

        return false;
    }

    /**
     * @param Logginable $logginable
     */
    public function login(Logginable $logginable)
    {
        $this->{static::SESSION_ID_KEY} = $logginable->getId();
        $this->{static::SESSION_NAME_KEY} = $logginable->getName();
    }

    public function logout()
    {
        $this->{static::SESSION_ID_KEY} = null;
        $this->{static::SESSION_NAME_KEY} = null;
        session_destroy();
    }

    public function __get($name) {
        if(array_key_exists($name, $_SESSION)) {
            return $_SESSION[$name];
        } else {
            return null;
        }
    }

    public function __set($name, $value)
    {
        $_SESSION[$name] = $value;
    }
}