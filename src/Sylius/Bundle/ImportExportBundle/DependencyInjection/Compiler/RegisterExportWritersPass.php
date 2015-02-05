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
class RegisterExportWritersPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('sylius.registry.export.writer')) {
            return;
        }

        $registry = $container->getDefinition('sylius.registry.export.writer');
     
        $writer = array();

        foreach ($container->findTaggedServiceIds('sylius.export.writer') as $id => $attributes) {
            if (!isset($attributes[0]['writer']) || !isset($attributes[0]['label'])) {
                throw new \InvalidArgumentException('Tagged writers needs to have `writer` and `label` attributes.');
            }

            $name = $attributes[0]['writer'];
            $writer[$name] = $attributes[0]['label'];

            $registry->addMethodCall('register', array($name, new Reference($id)));
        }
        $container->setParameter('sylius.writers', $writer);
    }
}
