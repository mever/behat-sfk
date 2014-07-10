<?php

namespace Realtime\SfkBehat;

class Sfk
{
    const TEMP_DIR = '/tmp';
    const TEMP_PREFIX = 'realtimeSfkBehat';

    private $runDirectory;
    private $processes = array();

    public function __construct()
    {
        $dir = escapeshellarg(self::TEMP_DIR);
        $prefix = escapeshellarg(self::TEMP_PREFIX);
        $this->runDirectory = trim(exec("mktemp --tmpdir={$dir} -d {$prefix}.XXXXXXX"));
        chmod($this->runDirectory, 0777);    // TODO: check this
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
                $process = new Command\FtpservCommand($this);
                $this->processes[] = $process;
                return $process;

            default:
                $state = new ExitState();
                $state->exitMessage = 'command not implemented';
                $state->exitCode = 0;
                return $state;
        }
    }

    /**
     * Empty the content of a directory.
     */
    public function  cleanDir($dir)
    {
        if (! is_dir($dir)) {
            throw new \InvalidArgumentException("Given string: '{$dir}' is not a directory.");
        }

        $basePath = self::TEMP_DIR . '/' . self::TEMP_PREFIX;
        if (false === strpos($dir, $basePath)) {
            throw new \InvalidArgumentException("Directory to clean is not beneath: " . $basePath);
        }

        exec('rm -fr ' . escapeshellarg($dir) . '/*');
    }

    /**
     * Return the run directory of this extension.
     *
     * @return string
     */
    public function getRunDirectory()
    {
        return $this->runDirectory;
    }

    /**
     * Return path to the SFK binary.
     *
     * @return string
     */
    public function getProgramPath()
    {
        return trim(`which sfk`);
    }

    /**
     * Cleanup running SFK processes.
     */
    public function cleanup()
    {
        foreach ($this->processes as $process) {
            $process->cleanup();
        }
    }

    /**
     * Cleanup run directory.
     */
    public function __destruct()
    {
        rmdir($this->runDirectory);
    }
}