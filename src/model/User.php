<?php

namespace model;

use core\Logginable;
use core\Model;

class User extends Model implements Logginable
{

    public static function getTableName()
    {
        return 'user';
    }

    public function getAttributeNames()
    {
        return [
            'userId' => 'User ID',
            'name' => 'User name',
            'email' => 'Email',
            'password' => 'Password',
        ];
    }

    public function getPrimaryKeyName()
    {
        return 'userId';
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getName()
    {
        return $this->name;
    }
}