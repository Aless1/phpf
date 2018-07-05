<?php

namespace Framework\Factory;

use MongoDB\Collection;

class Db
{
    private static $m_mongos = [];
    private static $m_colls = [];

    public static function getMongoInst($cstr)
    {
        if ( !isset(self::$m_mongos[$cstr]) ) {
            self::$m_mongos[$cstr] = new \MongoDB\Driver\Manager($cstr);
        }
        return self::$m_mongos[$cstr];
    }

    public static function getMongoCollInst($cstr, $db, $coll, $option = [])
    {
        $key = "{$cstr}:{$db}:{$coll}";
        if (!isset(self::$m_colls[$key])) {
            $type_map = array('root' => 'array', 'document' => 'array');
            $options['typeMap'] = $type_map;
            $mongo_driver = self::getMongoInst($cstr);
            self::$m_colls[$key] = new \MongoDB\Collection($mongo_driver, $db, $coll, $options);
            // self::$m_colls[$key] = new \Framework\DB\Mongo\CollBase($mongo_driver, $db, $coll, $options);
        }
        return self::$m_colls[$key];
    }
}