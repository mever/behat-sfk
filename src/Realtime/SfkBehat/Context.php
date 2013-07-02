<?php

namespace Realtime\SfkBehat;

use Behat\Behat\Context\BehatContext;

class Context extends BehatContext
{
    /**
     * @var \Realtime\SfkBehat\Sfk
     */
    public $sfkService;

    /**
     * @Given /^an local FTP server running on port "([^"]*)"$/
     */
    public function anLocalFtpServerRunningOnPort($port)
    {
        $ftpServer = $this->sfkService->run('ftpserv');
        $ftpServer->listen($port);
    }
}