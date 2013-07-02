<?php

namespace Realtime\SfkBehat;

use Behat\Behat\Extension\Extension as BaseExtension;

use Symfony\Component\DependencyInjection\ContainerBuilder,
    Symfony\Component\DependencyInjection\Loader\XmlFileLoader,
    Symfony\Component\Config\FileLocator;

class Extension extends BaseExtension
{
    public function load(array $config, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__));
        $loader->load('services.xml');
    }
}
