<?php

namespace Realtime\SfkBehat\Command;

interface RunStateInterface
{
    /**
     * Return the exit state of an executed command. If the
     * command is still running this returns null.
     *
     * @return \Realtime\SfkBehat\ExitState
     */
    public function getExitState();
}