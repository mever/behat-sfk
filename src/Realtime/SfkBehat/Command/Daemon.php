<?php

namespace Realtime\SfkBehat\Command;

use Realtime\SfkBehat\Sfk;

abstract class Daemon implements RunStateInterface
{
    const WORK_DIR = 'workDir';

    /**
     * Command name, overwrite this in the subclass.
     *
     * @var string
     */
    protected $command;

    /**
     * @var Realtime\SfkBehat\Sfk
     */
    protected $sfk;

    /**
     * Private working directory for the daemon.
     *
     * @var string
     */
    private $workDir;

    /**
     * Create a new daemon command.
     *
     * @param Sfk $sfk
     */
    public function __construct(Sfk $sfk)
    {
        $this->sfk = $sfk;
        if (null === $this->command) {
            throw new \LogicException("No command name is set!");
        }
    }

    /**
     * Start the command as deamon.
     *
     * @param array $parameters
     */
    public function start(array $parameters)
    {
        if ($this->isRunning()) {
            return;
        }

        $binPath = escapeshellarg($this->sfk->getProgramPath());
        $pidFile = escapeshellarg($this->getPidFile());
        $args = array(escapeshellarg($this->command));
        foreach ($parameters as $param) {
            $args[] = escapeshellarg($param);
        }

        exec("start-stop-daemon --start -b -x {$binPath} -m -p {$pidFile} -- " . join(' ', $args));
    }

    /**
     * Stop the daemonized command.
     */
    public function stop()
    {
        if ($this->isRunning()) {
            $pidFile = $this->getPidFile();
            $stdout = exec("start-stop-daemon --stop --oknodo --retry=5 -p " . escapeshellarg($pidFile));
            if (! $stdout) {
                unlink($pidFile);
            }
        }
    }

    /**
     * Cleanup daemon work directory.
     */
    public function cleanup()
    {
        $this->stop();
        if (null !== $this->workDir) {
            $this->sfk->cleanDir($this->workDir);
            rmdir($this->workDir);
            $this->workDir = null;
        }
    }

    /**
     * Return if this daemon is running.
     *
     * @return boolean
     */
    public function isRunning()
    {
        return file_exists($this->getPidFile());
    }

    /**
     * Return exit state.
     */
    public function getExitState()
    {
        return null;
    }

    /**
     * Return working directory for the daemon to play in.
     *
     * @return string
     */
    protected function getWorkDir()
    {
        $this->workDir = $this->sfk->getRunDirectory() . '/' . $this->command . ucfirst(self::WORK_DIR);
        exec('mkdir -p ' . escapeshellarg($this->workDir));
        return $this->workDir;
    }

    /**
     * Return PID file path.
     *
     * @return string
     */
    protected function getPidFile()
    {
        return $this->sfk->getRunDirectory() . "/{$this->command}.pid";
    }
}