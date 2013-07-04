<?php

namespace Realtime\SfkBehat\Command;

class FtpservCommand extends Daemon
{
    protected $command = 'ftpserv';

    /**
     * Start and listen for FTP connections.
     *
     * @param integer $port
     * @param array $options
     */
    public function listen($port, array $options = array())
    {
        $args = array('-port=' . $port, '-rw', $this->getWorkDir());

        foreach ($options as $name => $value) {
            switch ($name) {
                case 'username':
                    $args[] = '-user=' . $value;
                    break;

                case 'password':
                    $args[] = '-pw=' . $value;
                    break;
            }
        }

        $this->start($args);
    }
}