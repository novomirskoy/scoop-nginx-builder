<?php

namespace Novomirskoy\ScoopNginxBuilder\Command\Factory;

use GuzzleHttp\Psr7\Request;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Novomirskoy\ScoopNginxBuilder\Command\Hash;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class HashFactory
 * @package Novomirskoy\ScoopNginxBuilder\Command\Factory
 */
class HashFactory implements FactoryInterface
{
    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return Hash
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when
     *     creating a service.
     * @throws ContainerException if any other error occurs
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        
        return new Hash($container->get('config')['upload-directory']);
    }
}
