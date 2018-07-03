<?php

namespace Game\common;

class GameLogicException extends \Framework\Exception\GameExceptionBase
{
    protected function setCodeByMessage()
    {
        if (isset(\Game\ErrorCode::$GAME_LOGIC_ERROR[$this->message])) {
            $this->code = \Game\ErrorCode::$GAME_LOGIC_ERROR[$this->message];
        } else {
            $this->code = \Game\ErrorCode::UNKNOWN_ERROR;
        }
    }
}