<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Sylius\Bundle\ImportExportBundle\Form\Type\Writer;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @author Mateusz Zalewski <mateusz.zalewski@lakion.com>
 */
class CsvWriterTypeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Sylius\Bundle\ImportExportBundle\Form\Type\Writer\CsvWriterType');
    }

    function it_should_be_abstract_type_object()
    {
        $this->shouldHaveType('Symfony\Component\Form\AbstractType');
    }

    function it_builds_form_with_csv_writer_configuration(FormBuilderInterface $builder)
    {
        $builder->add('delimiter', 'text', Argument::any())->shouldBeCalled()->willReturn($builder);
        $builder->add('enclosure', 'text', Argument::any())->shouldBeCalled()->willReturn($builder);
        $builder->add('add_header', 'checkbox', Argument::any())->shouldBeCalled()->willReturn($builder);
        $builder->add('file', 'text', Argument::any())->shouldBeCalled()->willReturn($builder);

        $this->buildForm($builder, array());
    }

    function it_has_name()
    {
        $this->getName()->shouldReturn('sylius_csv_writer');
    } 
}