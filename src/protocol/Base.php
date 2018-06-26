<?php

namespace Framework\Protocol;

interface Base
{	
    public static function decode($inputParams);

    public static function encode($data);
}
