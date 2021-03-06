<?php
namespace Api\Controller\Plugin\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Api\Controller\Plugin\AuthPlugin;
use Zend\Db\Adapter\Adapter;
use Zend\Authentication\Adapter\DbTable\CallbackCheckAdapter;
use Api\Service\UserManager;

/**
 * This is the factory for IndexController. Its purpose is to instantiate the
 * controller and inject dependencies into it.
 */
class AuthPluginFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $dbAdapter      = $container->get(Adapter::class);
        return new AuthPlugin(
            new CallbackCheckAdapter($dbAdapter), 
            $container->get(UserManager::class)
            );
    }
}