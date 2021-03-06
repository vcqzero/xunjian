<?php
namespace Api\Service\Server\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Api\Service\Server\Weixiner;

/**
 * This is the factory for IndexController. Its purpose is to instantiate the
 * controller and inject dependencies into it.
 */
class WeixinerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $cache      = $container->get('filesystem');
        $weixinConfig = $container->get('config')['weixin'];
        return new Weixiner($cache, $weixinConfig);
    }
}