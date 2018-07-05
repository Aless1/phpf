<?php

namespace Game\schema;

class User extends \Framework\Schema
{
    public $fields = [
        '_id' => self::STR,
        'name' => self::STR,
    ];
}