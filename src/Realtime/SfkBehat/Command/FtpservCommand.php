<?php

namespace Realtime\SfkBehat\Command;

class FtpserveCommand extends Daemon
{
    public function listen($port)
    {
        var_dump($this->runDirectory);
    }
}