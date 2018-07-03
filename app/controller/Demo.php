<?php

namespace Game\controller;

class Demo extends \Game\common\GameController
{
    public function test()
    {
        //dump([['ok' => 'ccc'], ['ok' => 'ccc']]);
        $a = getParam($this->request, 'a','int');
        // throw new \Game\common\GameLogicException('network_error', ['type'=>'battle']);
        $this->success(['a' => $a]);
    }
}