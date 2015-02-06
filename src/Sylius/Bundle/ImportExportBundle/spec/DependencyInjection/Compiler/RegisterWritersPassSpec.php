<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Sylius\Bundle\ImportExportBundle\DependencyInjection\Compiler;

use PhpSpec\ObjectBehavior;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Łukasz Chruściel <lukasz.chrusciel@lakion.com>
 */
class RegisterWritersPassSpec extends ObjectBehavior
{

    public function it_should_implement_compiler_pass_interface()
    {
        $this->shouldImplement('Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface');
    }

    public function it_processes_with_given_container(
        ContainerBuilder $container, Definition $writerDefinition)
    {
        $container->hasDefinition('sylius.registry.export.writer')->willReturn(true);
        $container->getDefinition('sylius.registry.export.writer')->willReturn($writerDefinition);
        $writerServices = array(
            'sylius.form.type.writer.test' => array(
            array('writer' => 'test', 'label' => 'Test writer'),
            ),
        );
        $container->findTaggedServiceIds('sylius.export.writer')->willReturn($writerServices);
        $writerDefinition->addMethodCall('register', array('test', new Reference('sylius.form.type.writer.test')))->shouldBeCalled();
        $container->setParameter('sylius.writers', array('test' => 'Test writer'))->shouldBeCalled();
        $this->process($container);
    }

    public function it_does_not_process_if_container_has_not_proper_definition(ContainerBuilder $container)
    {
        $container->hasDefinition('sylius.registry.writer')->willReturn(false);
        $container->getDefinition('sylius.registry.writer')->shouldNotBeCalled();
    }

    public function it_throws_exception_if_any_writer_has_improper_attributes(ContainerBuilder $container, Definition $writerDefinition)
    {
        $container->hasDefinition('sylius.registry.writer')->willReturn(true);
        $container->getDefinition('sylius.registry.writer')->willReturn($writerDefinition);
        $writerServices = array(
            'sylius.form.type.writer.test' => array(
            array('writer' => 'test'),
            ),
        );
        $container->findTaggedServiceIds('sylius.writer')->willReturn($writerServices);
        $this->shouldThrow(new \InvalidArgumentException('Tagged writers needs to have `writer` and `label` attributes.'));
        $writerDefinition->addMethodCall('register', array('test', new Reference('sylius.form.type.writer.test')))->shouldNotBeCalled();
    }

}