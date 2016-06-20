<?php

namespace Novomirskoy\ScoopNginxBuilder\Command\Factory;

use GuzzleHttp\Psr7\Request;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Novomirskoy\ScoopNginxBuilder\Command\LatestVersion;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class LatestVersionFactory
 * @package Novomirskoy\ScoopNginxBuilder\Command\Factory
 */
class LatestVersionFactory implements FactoryInterface
{
    /**
     * Create LatestVersion command
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * 
     * @return LatestVersion
     * 
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when
     *     creating a service.
     * @throws ContainerException if any other error occurs
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $request = new Request('GET', $container->get('config')['nginx-download-path']);
        
        return new LatestVersion($request);
    }
}
