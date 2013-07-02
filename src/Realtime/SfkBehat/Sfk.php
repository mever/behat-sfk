<?php

namespace Realtime\SfkBehat;

use Realtime\SfkBehat\Command\FtpserveCommand;

class Sfk
{
    private $runDirectory;

    public function __construct()
    {
        $this->runDirectory = trim(exec('mktemp --tmpdir -d realtimeSfkBehat.XXXXXXX'));
    }

    /**
     * Execute SFK command.
     *
     * @param string $command
     * @return \Realtime\SfkBehat\Command\RunStateInterface
     */
    public function run($command)
    {
        switch ($command) {
            case 'ftpserv':
                return new FtpserveCommand($this);

            default:
                $state = new ExitState();
                $state->exitMessage = 'command not implemented';
                $state->exitCode = 0;
                return $state;
        }
    }

    public function getRunDirectory()
    {
        return $this->runDirectory;
    }

    public function __destruct()
    {
        rmdir($this->runDirectory);
    }
}