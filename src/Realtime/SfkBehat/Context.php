<?php

namespace Realtime\SfkBehat;

use Behat\Behat\Context\BehatContext,
    Behat\Gherkin\Node\PyStringNode;

class Context extends BehatContext
{
    /**
     * @var \Realtime\SfkBehat\Sfk
     */
    public $sfkService;

    /**
     * @var \Realtime\SfkBehat\Command\FtpservCommand
     */
    protected $ftpServer;

    /**
     * @Given /^a local FTP server running on port "([^"]*)" with these options(:| \'([^\']*)\')$/
     */
    public function aLocalFtpServerRunningOnPort($port, $_, $rawOptions)
    {
        $options = json_decode(($rawOptions instanceof PyStringNode) ? $rawOptions->getRaw() : $rawOptions, true);

        $this->ftpServer = $this->sfkService->run('ftpserv');
        $this->ftpServer->listen($port, $options);
    }

    /**
     * @Then /^FTPed file "([^"]*)" must be created, containing:$/
     */
    public function thisFtpFileShouldBeCreated($fileName, PyStringNode $content)
    {
        if (null === $this->ftpServer || ! $this->ftpServer->isRunning()) {
            throw new \LogicException("No FTP server running");
        }

        $file = $this->ftpServer->getRootDir() . "/{$fileName}";
        if (! file_exists($file)) {
            throw new \RuntimeException("No FTPed file {$fileName} found!");
        }

        $expected = trim($content->getRaw());
        $actual = trim(file_get_contents($file));
        if ($actual !== $expected) {
            throw new \RuntimeException("File content mismatch, actual:\n{$actual}");
        }
    }

    /**
     * @AfterScenario
     */
    public function cleanup()
    {
        $this->sfkService->cleanup();
    }
}