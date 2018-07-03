<?php

namespace Game\common;

class GameController
{
    public $request;
    public function __construct($params)
    {
        $this->request = $params;
    }
    public function run($action)
    {
        try {
            $this->$action();
        } catch (GameLogicException $ex) {
            call_user_func_array(array(getapp()->getProtocolClass(), 'error'), array($ex));
        }
    }

    public function success($data = [])
    {
        call_user_func_array(array(getapp()->getProtocolClass(), 'success'), [$data]);
    }

    public function append($data)
    {
        call_user_func_array(array(getapp()->getProtocolClass(), 'append'), [$data]);
    }
}