<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Sylius\Component\ImportExport\Model;

use PhpSpec\ObjectBehavior;

/**
 * @author Mateusz Zalewski <mateusz.zalewski@lakion.com>
 */
class ProfileSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Sylius\Component\ImportExport\Model\Profile');
    }

    public function it_implements_job_interface()
    {
        $this->shouldImplement('Sylius\Component\ImportExport\Model\ProfileInterface');
    }

    public function it_has_name()
    {
        $this->setName("testProfile");
        $this->getName()->shouldReturn('testProfile');
    }

    public function it_has_code()
    {
        $this->setCode('testCode');
        $this->getCode()->shouldReturn('testCode');
    }

    public function it_has_description()
    {
        $this->setDescription('testDescription');
        $this->getDescription()->shouldReturn('testDescription');
    }

    public function it_has_entity()
    {
        $this->setEntity('testEntity');
        $this->getEntity()->shouldReturn('testEntity');
    }

    public function it_has_fields()
    {
        $fields = array('field1', 'field2');
        $this->setFields($fields);
        $this->getFields()->shouldReturn($fields);
    }
}