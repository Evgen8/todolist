<?php

namespace core;

abstract class Model {

    protected $_attributes = [];

    /**
     * @return string
     */
    public static function getTableName() {
        throw new Exception("Not implementded table name method");
    }

    /**
     * [
     *   'columnInDbName' => 'User readable name',
     *   'firstName' => 'First Name',
     * ]
     * @return array
     */
    abstract public function getAttributeNames();

    /**
     * Db column name of primaryKey
     *
     * @return string
     */
    abstract public function getPrimaryKeyName();

    public function getPrimaryKey() {
        if(!array_key_exists(
            $this->getPrimaryKeyName(),
            $this->_attributes
        )) {
            return null;
        }
        return $this->_attributes[$this->getPrimaryKeyName()];
    }

    /**
     * $a->firstName  >>>>>  $a[_attributes]['firstName']
     *
     * @param $name
     * @return mixed|null
     * @throws \LogicException
     */
    public function __get($name) {
        if(array_key_exists($name, $this->_attributes)) {
            return $this->_attributes[$name];
        } elseif (!array_key_exists($name,$this->getAttributeNames())) {
            throw new \LogicException("No attribute '{$name}' for model ".get_called_class()." available. ");
        } else {
            return null;
        }
    }

    /**
     * $a->firstName = 1;
     *
     * @param $name
     * @param $value
     * @throws \LogicException
     */
    public function __set($name, $value)
    {
        if(array_key_exists($name, $this->getAttributeNames()) ) {
            throw new \LogicException("Can't set attribute '{$name}' for model ".get_called_class());
        }

        $this->_attributes[$name] = $value;
    }

    public function setAttributes($attributes) {
        /**
         * @todo: add check of availability of columns
         */
        $this->_attributes = array_intersect_key($attributes,$this->getAttributeNames());
    }

    public function __construct($attributes = []) {
        $this->setAttributes($attributes);
    }

    /**
     * @param string $condition
     * @param array $params
     * @return mixed
     */
    public static function findOne($condition = '',$params = []) {
        $tableName = static::getTableName();

        /**
         * @todo: write query builder
         */
        $sql = 'SELECT * from `'.$tableName.'` '.($condition ? 'WHERE '.$condition : '').' LIMIT 1';

        $data = Db::getInstance()->queryOne($sql,$params);

        return new static($data);
    }

    public static function find($condition = '',$params = []) {
        $tableName = static::getTableName();
        /**
         * @todo: add limitation for data
         */
        $sql = 'SELECT * from `'.$tableName.'` '.($condition ? 'WHERE '.$condition : '');

        $data = Db::getInstance()->queryAll($sql,$params);

        foreach ($data as $row) {
            $models[] = new static($row);
        }

        return $models;
    }

    public function save()
    {
        $tableName = static::getTableName();
        /**
         * @todo: add limitation for data
         */
        $sql = "INSERT INTO `{$tableName}` (`name`,`email`,`password`) VALUES ( :name, :email, :password )";

        $data = Db::getInstance()->save($sql, $this->_attributes);

        return $data;
    }

}