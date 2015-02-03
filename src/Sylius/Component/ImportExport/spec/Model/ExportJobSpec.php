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
class ExportJobSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Sylius\Component\ImportExport\Model\ExportJob');
    }

    public function it_is_job_object()
    {
        $this->shouldHaveType('Sylius\Component\ImportExport\Model\Job');
    }

    // public function it_has_export_profile()
    // {
    //     $exportProfile = new \Sylius\Component\ImportExport\ExportProfile();
    //     $this->setExportProfile($exportProfile);
    //     $this->getExportProfile()->shouldReturn($exportProfile);
    // }
}