<?php

function getParam($params, $key, $type = null, $require = true, $default = null) {
	$isCheck = true;
	if (!isset($params[$key]) || is_null($params[$key]))
	{
	    // 如果必须项
	    if($require)
	    {
	        throw new Arsenal\Exception\LogicAlertException("param_not_exist", array('key' => $key,'params' => $params));
	    }

	    if($default !== null)
	    {
	        $isCheck = false;
	    }

	    if(!is_null($default))
	    {
	        $params[$key] = $default;
	    }
	    else
	    {
	        throw new Arsenal\Exception\LogicAlertException("param_not_exist", array('key' => $key,'params' => $params));
	    }
	}
	$param = $params[$key];
	switch ($type)
	{
	    case 'int':
	        $param = intval($param);
	        break;
	    case 'float':
	        $param = floatval($param);
	        break;
	    case 'string':
	        $param = strval($param);
	        break;
	    case 'json':
	        $param = json_decode(htmlspecialchars_decode($param),true);
	        if (!is_array($param))
	        {
	            throw new Arsenal\Exception\LogicAlertException("invalid_param", array('key' => $key,'params' => $params));
	        }
	        break;
	    case 'array':
	        if (!is_array($param))
	        {
	            throw new Arsenal\Exception\LogicAlertException("invalid_param", array('key' => $key,'params' => $params));
	        }
	        break;
	    case 'mobile':
	        if($isCheck && preg_match('/^0?(13[0-9]|15[012356789]|18[0-9]|14[57]|17[0678])[0-9]{8}$/',$param)!==1)
	        {
	            throw new Arsenal\Exception\LogicAlertException("invalid_param");
	        }
	        break;
	    case 'password':
	        if($isCheck && preg_match('/^\w{4,32}$/',$param)!==1)
	        {
	            throw new Arsenal\Exception\LogicAlertException("invalid_param");
	        }
	        break;
	}
	return $param;
}

function whereCalled($level = 1) {
	$trace = debug_backtrace();
	$file = $trace[$level]['file'];
	$line = $trace[$level]['line'];
    if (isset($trace[$level]['object'])){
        $object = $trace[$level]['object'];
        if (is_object($object)) {
            $object = get_class($object);
        }
    }else{
        $object = "";
    }
	return "$file ($line) $object";
}

function hasArrayChild(&$v) {
	if (is_array($v)) {
		foreach ($v as &$vv) {
			if (is_array($vv)) {
				return true;
			}
		}
	}
	return false;
}

function ppp($key, $value, $indent) {
	$prefix = '';
	for ($i = 0; $i < $indent; $i++) {
		$prefix .= '    ';
	}
	$suffix = $indent ? ',' : ';';
	$str = '';
	if ($key !== null) {
		$key = addslashes($key);
		$str .= $prefix . "'$key'=>";
	}
	if (hasArrayChild($value)) {
		$str .= "{\n";
		foreach ($value as $k => $v) {
			$str .= ppp($k, $v, $indent + 1);
		}
		$str .= $prefix . "}$suffix\n";
	} else {
		$value_str = json_encode($value);
		$str .= "$value_str$suffix\n";
	}
	return $str;
}

function dump($param) {
	$loc = whereCalled();
	echo "\n$loc\n";
	echo ppp(null, $param, 0);
}