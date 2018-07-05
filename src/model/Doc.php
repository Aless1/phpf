<?php

namespace Framework\Model;

class Doc extends MAbstract
{
    private $_db_conn = null;
    public  $dbparam = [];

    public function setDbIndex($index = array())
    {
        if ($index == null || !is_array($index)){
            return;
        }
        if (is_array($index)) {
            foreach($index as $key => $value) {
                $this->$key = $value;
            }
            $this->_db_index = $index;
        }else {
            throw new LogicAlertException("invalid_param", array('msg'=>'index must to be array when try to set index to a model'));
        }
    }

    public function getFields($fields)
    {
        $proj = array_fill_keys($this->array2path('', $fields), 1);
        $data = $this->getdb()->findOne($this->getDbQueryCond(), ['projection' => $proj]);
        $this->fillData($data);
        return $data;
    }

    public function getDbQueryCond()
    {
        if (isset($this->_id)) {
            return array('_id'=> $this->_id);
        }
        if (!empty($this->_db_index)) {
            return $this->_db_index;
        }
        return false;
    }

    public function getdb(){
        if (is_null($this->_db_conn)) {
            if (empty($this->dbparam)) {
                throw new \Framework\Exception\LogicAlertException("dbparam_not_found");
            }

            $cstr = 'mongodb://localhost:27017';
            $this->_db_conn = \Framework\Factory\Db::getMongoCollInst($cstr, $this->dbparam['db'], $this->dbparam['coll']);

        }
        return $this->_db_conn;
    }

    function array2path($root, $arr){
        $ret = array();
        if(is_array($arr)){
            foreach($arr as $k=>$v){
                if(is_array($v)){
                    $ret2 = array2path($root.$k.'.', $v );
                    $ret = array_merge($ret2,$ret);
                }else{
                    $ret[] = $root.$v.'.';
                }
            }
        }else{
            $ret[] = $root.$arr.'.';
        }
        return $ret;
    }
}