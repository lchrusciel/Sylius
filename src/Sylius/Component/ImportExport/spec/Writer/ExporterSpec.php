<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Sylius\Component\ImportExport\Exporter;

use PhpSpec\ObjectBehavior;
use Sylius\Component\Registry\ServiceRegistryInterface;
use Sylius\Component\ImportExport\Model\ExportProfile;
use Sylius\Bundle\ImportExportBundle\Exporter\CsvExporter;

/**
 * @author Mateusz Zalewski <mateusz.zalewski@lakion.com>
 */
class ExporterSpec extends ObjectBehavior
{
    function let(ServiceRegistryInterface $registry)
    {
        $this->beConstructedWith($registry);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Sylius\Component\ImportExport\Exporter\DelegatingExporter');
    }

    function it_implements_delegating_exporter_interface()
    {
        $this->shouldImplement('Sylius\Component\ImportExport\Exporter\DelegatingExporterInterface');
    }

    // function it_exports_data_with_given_exporter($registry, ExportProfile $exportProfile, CsvExporter $csvExporter)
    // {
    //     $exportProfile->getEntity()->willReturn('Sylius/Component/Product/Model/Product');
    //     $exportProfile->getFields()->willReturn(array());
    //     $exportProfile->getExporterConfiguration()->willReturn(array('file' => 'output.csv'));
    //     $exportProfile->getExporter()->willReturn('csv');
        
    //     $registry->get('csv')->willReturn($csvExporter);
    //     $csvExporter->export('Sylius/Component/Product/Model/Product', array(), array('file' => 'output.csv'))->shouldBeCalled();

    //     $this->export($exportProfile);
    // }
}