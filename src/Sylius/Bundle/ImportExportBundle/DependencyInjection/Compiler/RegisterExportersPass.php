<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\ImportExportBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Registers all exporters in export profile registry service.
 *
 * @author Łukasz Chruściel <lukasz.chrusciel@lakion.com>
 * @author Bartosz Siejka <bartosz.siejka@lakion.com>
 */
class RegisterExportersPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('sylius.registry.exporter')) {
            return;
        }

        $registry = $container->getDefinition('sylius.registry.exporter');
        
        $exporter = array();

        foreach ($container->findTaggedServiceIds('sylius.exporter') as $id => $attributes) {
            if (!isset($attributes[0]['exporter']) || !isset($attributes[0]['label'])) {
                throw new \InvalidArgumentException('Tagged exporters needs to have `exporter` and `label` attributes.');
            }

            $name = $attributes[0]['exporter'];
            $exporter[$name] = $attributes[0]['label'];

            $registry->addMethodCall('register', array($name, new Reference($id)));
        }
        $container->setParameter('sylius.exporters', $exporter);
    }
}
