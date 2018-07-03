<?php

namespace Framework;

class Application
{
    protected $input_params = [];

    protected $server_maps = array(
        '_default'  => 'Framework\server\IServer',
    );

    protected $protocol_maps = array(
        '_default'  => 'Framework\protocol\Http',
    );

    protected $run_mod;

    public function run($mod)
    {
        $this->run_mod = $mod;

        $request = call_user_func(array($this->getProtocolClass(), 'decode'), $this->input_params);
        $server_class = $this->getServerClass();
        try {
            $server = new $server_class();
            $server->run($request);
        } catch(\Exception $ex) {
            call_user_func_array(array($this->getProtocolClass(), 'error'), array($ex));
        }
    }

    public function getServerClass()
    {
        return $this->server_maps[$this->run_mod] ?? $this->server_maps['_default'];
    }

    public function getProtocolClass()
    {
        return $this->protocol_maps[$this->run_mod] ?? $this->protocol_maps['_default'];
    }

    private static $instance = NULL;
    static function &getInstance() {
        if (NULL == self::$instance) {
            self::$instance = new static();
        }
        return self::$instance;
    }
}