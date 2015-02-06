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
 * Registers all readers in export profile registry service.
 *
 * @author Łukasz Chruściel <lukasz.chrusciel@lakion.com>
 * @author Mateusz Zalewski <mateusz.zalewski@lakion.com>
 */
class RegisterExportReadersPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('sylius.registry.export.reader')) {
            return;
        }

        $registry = $container->getDefinition('sylius.registry.export.reader');
     
        $readers = array();

        foreach ($container->findTaggedServiceIds('sylius.export.reader') as $id => $attributes) {
            if (!isset($attributes[0]['reader']) || !isset($attributes[0]['label'])) {
                throw new \InvalidArgumentException('Tagged readers needs to have `reader` and `label` attributes.');
            }

            $name = $attributes[0]['reader'];
            $readers[$name] = $attributes[0]['label'];

            $registry->addMethodCall('register', array($name, new Reference($id)));
        }
        $container->setParameter('sylius.readers', $readers);
    }
}
