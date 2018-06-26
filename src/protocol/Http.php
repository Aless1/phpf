<?php

namespace Framework\Protocol;

class Http implements Base
{
    public static function decode($inputParams)
    {
        $requestParam = [];
        foreach ($_REQUEST as $k => $v) {
            $requestParam[$k] = $v;
        }
        return $requestParam;
    }
 
    public static function encode($data)
    {
        if (is_array($data)) {
            return json_encode($data);
        }
        return $data;
    }
}