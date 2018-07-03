<?php

namespace Framework\Exception;

class LogicAlertException extends GameExceptionBase
{
    protected function setCodeByMessage()
    {
        if (constant('Framework\ErrorCode::' . $this->message)) {
            $this->code = constant('Framework\ErrorCode::'.$this->message);
        } else {
            $this->code = \Framework\ErrorCode::UNKNOWN_ERROR;
        }
    }
}