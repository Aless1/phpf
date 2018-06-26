<?php

namespace Game\server;

use Framework;

class GameLogic implements \Framework\server\IServer
{
    public function run($request)
    {
        if (isset($request['method'])) {
            $apiInfo = explode('.', $request['method']);
            if (count($apiInfo) < 2) {
                throw new \Game\common\GameLogicException("invalid_param", array('method'=>$request['method']));
            }
            $request['controller'] = $apiInfo[0];
            $request['action'] = $apiInfo[1];
        }

        $controller = getParam($request, 'controller', 'string', false, 'Demo');
        $action     = getParam($request, 'action', 'string', false, 'test');
        $this->handleOne($controller, $action, $request);
    }

    public function handleOne($controller, $action, $param) {

        echo $controller . '__' . $action;
        // $class  = "\\Game\\controller\\" . $controller;
        // if (!class_exists($class)){
        //     throw new Framework\Exception\LogicAlertException("class_not_found",array('class' => $class));

        // }
        // if (!method_exists($class, $action)) {
        //     throw new Framework\Exception\LogicAlertException("method_not_exist", array('msg' =>'Oops! method $class::$action not exists'));
        // }
	    // $inst = new $class($param);
	    // return $inst->run($action);
    }
}