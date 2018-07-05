<?php

namespace Framework\common;

class Socket
{
    const SSL = 'ssl';
	const TCP = 'tcp';
    const UDP = 'udp';
    
    const MAX_LENGTH = 0x200000;

    private $sslOption = array(
		'verifyPeer'			=> 'verify_peer',
		'allowSelfSigned'		=> 'allow_self_signed',
		'cafile'				=> 'cafile',
		'capath'				=> 'capath',
		'cert'					=> 'local_cert',
		'passwd'				=> 'passphrase',
		'cnMatch'				=> 'CN_match',
		'verifyDepth'			=> 'verify_depth',
		'ciphers'				=> 'ciphers',
		'capturePeerCert'		=> 'capture_peer_cert',
		'capturePeerCertChain'	=> 'capture_peer_cert_chain',
		'sniEnabled'			=> 'SNI_enabled',
		'sniServerName'			=> 'SNI_server_name',
	);
	private $socketOption = array(
		'bind'					=> 'bindto',
		'backlog'				=> 'backlog',
    );
    
    private $transport = self::TCP;
    private $timeout = 60;

    private $context = null;
    private $socket = null;

	private $errno = 0;
    private $error = '';

    public function __construct($transport = self::TCP, $timeout = 60, $bind = null)
	{
		$this->transport = $transport;
		$this->timeout = $timeout;
        $this->context = stream_context_create();

		if(isset($bind)) {
			$this->setOption('bind', $bind);
		}
    }
    
    public function __destruct()
	{
		$this->close();
    }
    
    public function errno()
	{
		return $this->errno;
	}

	public function error()
	{
		return $this->error;
	}
    
    public function connect($host, $port, $flag = STREAM_CLIENT_CONNECT)
    {
        $remote = $this->transport . '://' . $host . ':' . $port;
        $this->socket = stream_socket_client($remote, $this->errno, $this->error, $this->timeout, $flag, $this->context);
        if(!$this->socket) {
			return false;
        }
        $this->setTimeout($this->timeout);
		return $this->socket;
    }

    public function send()
    {
        return fwrite($this->socket, $data);
    }

    public function recv($inline = false, $length = self::MAX_LENGTH)
    {
		if(!feof($this->socket)) {
			return $inline ? fgets($this->socket, $length) : fread($this->socket, $length);
		}
		return false;
    }

    public function close()
    {
        is_resource($this->socket) && fclose($this->socket);
    }

    public function setOption($option, $value)
	{
		if(isset($this->sslOption[$option])) {
			return stream_context_set_option($this->context, 'ssl', $this->sslOption[$option], $value);
		} elseif(isset($this->socketOption[$option])) {
			return stream_context_set_option($this->context, 'socket', $this->socketOption[$option], $value);
		}
		return false;
	}

    public function setBlocking($mode)
	{
		return stream_set_blocking($this->socket, $mode);
    }

    public function setTimeout($seconds, $microseconds = 0)
	{
		return stream_set_timeout($this->socket, $seconds, $microseconds);
    }
    
    public function getMeta()
	{
		return stream_get_meta_data($this->socket);
    }
}