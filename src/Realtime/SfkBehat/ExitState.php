<?php

namespace Realtime\SfkBehat;

class ExitState implements Command\RunStateInterface
{
    public $exitCode = 255;

    public $exitMessage = 'exit message not initialized';

    public function getExitState()
    {
        return $this;
    }
}