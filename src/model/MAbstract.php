<?php

namespace Framework\Model;

class MAbstract
{
    public $schema;
    public $root;

    public $data = [];

    public function __construct($schema, $root = null, $key = null)
    {
        $this->schema = $schema;
        $this->root = $root;
    }

    public function fillData(&$data, $cover = false)
    {
        if (!is_array($data)) {
            return false;
        }

        if ($this->is_new || empty($this->data)) {
            $this->data = &$data;
            return true;
        }

        foreach ($data as $k => $v) {
            $type = $this->_checkAndGetSchemaType($k, false);
            if (false === $type) {
                continue;
            }
            $this->_setdata($k, $v, $type, $cover);
        }
    }

    protected function _checkAndGetSchemaType($k, $strict = true)
    {
        $type = $this->schema->type($k);
        if ($type) {
            return $type;
        }
        if ($strict) {
            throw new LogicAlertException('property_not_exist', array('msg' => "key [$k] not exist in model,please define it in schema first"));
        }
        return false;
    }

    private function _setdata($k, &$v, $type, $cover = true)
    {
        // 纯数值
        if (is_numeric($type)) {
            if ($type == Schema::NUM) {
                $v = (int) $v;
            } elseif ($type == Schema::STR) {
                $v = (string) $v;
            } elseif ($type == Schema::FLOAT) {
                $v = floatval($v);
            }
            if (isset($this->data[$k]) && $cover == false) {
                return false;
            }
            $this->data[$k] = $v;
            if (isset($this->container[$k])) {
                $this->container[$k] = $v;
            }
            return true;
        }

        if (isset($this->container[$k])) {
            $this->container[$k]->fillData($v, $cover);
        } else {
            if (!isset($this->data[$k]) || !is_array($this->data[$k])) {
                $this->data[$k] = $v;
            } else {
                if ($cover) {
                    $this->data[$k] = array_replace_recursive($this->data[$k], $v);
                } else {
                    $this->data[$k] = array_replace_recursive($v, $this->data[$k]);
                }
            }
        }

        return true;
    }
}