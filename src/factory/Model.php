<?php

namespace Framework\Factory;

class Model
{
    private static $m_schemas = [];

    public static function getSchema($name){
        $name = "\\Game\\schema\\" . ucfirst($name);
        if (STRICT_FIELD_CHECK && !class_exists($name)){
            throw new LogicAlertException("schema_not_found", array('msg'=>"schema $name not exists, please define it first"));
        }
        if (!isset(self::$m_schemas[$name])){
            self::$m_schemas[$name] = new $name();
        }
        return self::$m_schemas[$name];
    }

    public static function getModel($name, $root = null, $key = null)
    {
        $name = ucfirst($name);
        $model_name =  '\\Game\\model\\' . $name;
        if(!class_exists($model_name)){
            $model_name = "\\Framework\\Model\\Embedded";
        }
        $model = new $model_name(self::getSchema($name), $root, $key);

        return $model;
    }

    public static function getDocModel($name, $index, $fields = array(), $dbParams= array())
    {
        $mod = self::getModel($name);
        $mod->setDbIndex($index);

        if (count($fields) == 0){
            foreach ($mod->schema->fields as $key => $v){
                $fields[] = $key;
            }
        }
        $mod->getFields($fields);
        return $mod;
    }
}