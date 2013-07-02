<?php

namespace Realtime\SfkBehat\Command;

class FtpservCommand extends Daemon
{
    public function listen($port)
    {
        var_dump($port);
    }
}