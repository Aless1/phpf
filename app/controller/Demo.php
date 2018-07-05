<?php

namespace Game\controller;

class Demo extends \Game\common\GameController
{
    public function test()
    {
        // $cstr = 'mongodb://localhost:27017';
        // $db = 'web';
        // $coll = 'message';
        // $mon = \Framework\Factory\Db::getMongoCollInst($cstr, $db, $coll, []);
        
        // $cursor = $mon->find();
        // foreach ($cursor as $document) {
        //     dump($document);
        // }

        $user = \Framework\Factory\Model::getDocModel('user', ['name' => 'ao'], ['_id', 'name']);
        dump($user);
        
        // $ret = $user->commit();
        // $this->success($ret);
        
        
        // //dump([['ok' => 'ccc'], ['ok' => 'ccc']]);
        // $a = getParam($this->request, 'a','int');
        // // throw new \Game\common\GameLogicException('network_error', ['type'=>'battle']);
        // $this->success(['a' => $a]);
    }
}