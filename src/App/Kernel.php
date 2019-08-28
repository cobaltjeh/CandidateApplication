<?php

declare(strict_types = 1);

namespace App;

use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Bundle\MonologBundle\MonologBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Routing\RouteCollectionBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;

/**
 * Class Kernel
 *
 * @author Jan de Wit <cobaltjeh@gmail.com>
 */
class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    const CONFIG_EXTS = '.{php,xml,yaml}';

    const API_ZONE_ATTRIBUTE = '_api_zone';
    const API_DOMAIN_ATTRIBUTE = '_api_domain';

    /**
     * @param ContainerBuilder $container
     * @param LoaderInterface $loader
     *
     * @throws \Exception
     */
    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader): void
    {
        //$container->setParameter('container.autowiring.strict_mode', true);
        $container->setParameter('container.dumper.inline_class_loader', true);

        $confDir = $this->getProjectDir() . '/app/Resources/config';

        $loader->load($confDir . '/default.xml');
        $loader->load($confDir . '/packages/*' . self::CONFIG_EXTS, 'glob');
        $loader->load($confDir . '/services.xml');
    }

    /**
     * @param RouteCollectionBuilder $routes
     */
    protected function configureRoutes(RouteCollectionBuilder $routes): void
    {
        // No routes required, since this is a console application
    }

    /**
     * @return BundleInterface[]
     */
    public function registerBundles(): array
    {
        return [
            new FrameworkBundle(),
            new MonologBundle(),
        ];
    }

    /**
     * Override the default cache directory
     *
     * @return string
     */
    public function getCacheDir(): string
    {
        return $this->config['cacheDir'] ?? $this->getProjectDir() . '/cache/' . $this->environment;
    }

    /**
     * Override the default logs directory
     *
     * @return string
     */
    public function getLogDir(): string
    {
        return $this->config['logDir'] ?? $this->getProjectDir() . '/logs';
    }
}
