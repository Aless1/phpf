<?php

namespace Framework\Protocol;

class Http implements Base
{
    private static $_response_buff = [];
    public static function decode($inputParams)
    {
        $requestParam = [];
        foreach ($_REQUEST as $k => $v) {
            $requestParam[$k] = $v;
        }
        return array_merge($requestParam, $inputParams);;
    }
 
    public static function encode($data)
    {
        if (is_array($data)) {
            return json_encode($data);
        }
        return $data;
    }

    public static function append(array $data)
    {
        self::$_response_buff = array_merge(self::$_response_buff, $data);
    }

    public static function success($data)
    {
        if($data) {
            self::append($data);
        }

        $success = array(
            'code'    => 0,
            'message' => 'ok',
            'data' => self::$_response_buff,
        );
        echo self::encode($success);
        $_response_buff = [];
    }

    public static function error($ex)
    {   
        $error = array(
            'code'    => $ex->getCode(),
            'message' => $ex->getMessage(),
            'data' => $ex->getData(),
        );
        echo self::encode($error);
    }
}