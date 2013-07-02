<?php

namespace Realtime\SfkBehat;

use Behat\Behat\Context\Initializer\InitializerInterface,
    Behat\Behat\Context\ClassGuesser\ClassGuesserInterface,
    Behat\Behat\Context\ContextInterface;

class Initializer implements InitializerInterface
{
    /**
     * Checks if initializer supports provided context.
     *
     * @param ContextInterface $context
     *
     * @return Boolean
     */
    public function supports(ContextInterface $context)
    {
        return ($context instanceof Context);
    }

    /**
     * Initializes provided context.
     *
     * @param ContextInterface $context
     */
    public function initialize(ContextInterface $context)
    {
        $context->sfkService = new Sfk();
    }
}