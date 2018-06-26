<?php

class App extends Framework\Application
{
    protected $server_maps = array(
        '_default'  => 'Game\server\GameLogic',
    );
}

function &getapp()
{
    return App::getInstance();
}