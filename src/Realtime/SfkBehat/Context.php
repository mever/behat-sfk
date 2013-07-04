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
     * @Given /^a local FTP server running on port "([^"]*)" with these options(:| \'([^\']*)\')$/
     */
    public function aLocalFtpServerRunningOnPort($port, $_, $rawOptions)
    {
        $options = json_decode(($rawOptions instanceof PyStringNode) ? $rawOptions->getRaw() : $rawOptions, true);

        $ftpServer = $this->sfkService->run('ftpserv');
        $ftpServer->listen($port, $options);
    }

    /**
     * @AfterScenario
     */
    public function cleanup()
    {
        $this->sfkService->cleanup();
    }
}