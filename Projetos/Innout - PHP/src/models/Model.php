<?php
class Model{
    protected static $tableName = '';
    protected static $columns = [];

    protected $values = [];

    function __construct($arr)
    {
        $this->loadFromArray($arr);
    }

    public function loadFromArray($arr){
        if($arr){
            foreach($arr as $index => $value){
                $this->$index = $value;
            }
        }
    }

    public function __get($key){
        return $this->values[$key];
    }

    public function __set($key,$value){
        $this->values[$key] = $value;
    }

    public static function getSelect($filters = [], $columns = '*'){
        $sql = "SELECT ${columns} FROM "
        .static::$tableName
        .static::getFilters($filters);
        return $sql;
    }

    private static function getFilters($filters){
        $sql = ' WHERE 1 = 1'; //Aqui eh adicionado o where a query, nao apague.
        if(count($filters) > 0){
            foreach($filters as $column=>$value){
                $sql .= "AND ${column} =".static::getFormattedValue($value);
            }
        }
        return $sql;
    }

    private static function getFormattedValue($value){
        if(is_null($value)){
            return "null";
        }else if(gettype($value) === 'string'){
            return "'${value}'";
        }else{
            return $value;
        }
    }
}