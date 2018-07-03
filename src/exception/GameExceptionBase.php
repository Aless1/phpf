<?php
namespace Framework\Exception;

class GameExceptionBase extends \Exception
{
    private $data = [];
    public function __construct($message, $data = [])
    {
        parent::__construct($message);
        $this->setCodeByMessage($this->message);
        $this->data = $data;
    }

    protected function setCodeByMessage() {}
    
    public function getData()
    {
        return $this->data;
    }
}