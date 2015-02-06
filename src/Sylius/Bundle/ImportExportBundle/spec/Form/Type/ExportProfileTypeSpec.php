<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Sylius\Bundle\ImportExportBundle\Form\Type;

use PhpSpec\ObjectBehavior;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Prophecy\Argument;
use Sylius\Component\Registry\ServiceRegistryInterface;

/**
 * @author Mateusz Zalewski <mateusz.zalewski@lakion.com>
 */
class ExportProfileTypeSpec extends ObjectBehavior
{
    function let(ServiceRegistryInterface $exporterRegistry)
    {
        $this->beConstructedWith('Sylius\Component\ImportExport\Model\ExportProfile', array('sylius'), $exporterRegistry);
    }   

    function it_is_initializable()
    {
        $this->shouldHaveType('Sylius\Bundle\ImportExportBundle\Form\Type\ExportProfileType');
    }

    function it_should_be_abstract_resource_type_object()
    {
        $this->shouldHaveType('Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType');
    }

    function it_build_form_with_proper_fields(
        FormBuilderInterface $builder,
        FormFactoryInterface $factory
    ) {
        $builder->getFormFactory()->willReturn($factory);

        $builder->addEventSubscriber(Argument::type('Sylius\Bundle\ImportExportBundle\Form\EventListener\BuildWriterFormListener'))->shouldBeCalled()->willReturn($builder);
        $builder->add('name', 'text', Argument::any())->shouldBeCalled()->willReturn($builder);
        $builder->add('code', 'text', Argument::any())->shouldBeCalled()->willReturn($builder);
        $builder->add('description', 'textarea', Argument::any())->shouldBeCalled()->willReturn($builder);
        $builder->add('writer', 'sylius_writer_choice', Argument::any())->shouldBeCalled()->willReturn($builder);

        $this->buildForm($builder, array());
    }

    function it_has_name()
    {
        $this->getName()->shouldReturn('sylius_export_profile');
    }
}