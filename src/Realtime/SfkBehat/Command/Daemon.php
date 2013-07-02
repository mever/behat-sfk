<?php

namespace Realtime\SfkBehat\Command;

use Realtime\SfkBehat\Sfk;

class Daemon implements RunStateInterface
{
    /**
     * @var Realtime\SfkBehat\Sfk
     */
    private $sfk;

    private $running = false;

    public function __construct(Sfk $sfk)
    {
        $this->sfk = $sfk;
    }

    public function isRunning()
    {
        return $this->running;
    }

    /**
     * Daemonize command.
     *
     * @param string $command
     */
    protected function daemonize($command)
    {
    }

    public function getExitState()
    {
        return null;
    }
}