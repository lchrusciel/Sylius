<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Sylius\Bundle\ImportExportBundle\Exporter;

use PhpSpec\ObjectBehavior;
use Doctrine\ORM\EntityManager;
use Ddeboer\DataImport\Workflow;
use Ddeboer\DataImport\Reader\DoctrineReader;
use Ddeboer\DataImport\Writer\CsvWriter;
use Ddeboer\DataImport\Filter\CallbackFilter;

/**
 * 
 * @author Mateusz Zalewski <mateusz.zalewski@lakion.com>
 */
class CsvExporterSpec extends ObjectBehavior
{
    function let(EntityManager $entityManager)
    {
        $this->beConstructedWith($entityManager);
    }   

    function it_is_initializable()
    {
        $this->shouldHaveType('Sylius\Bundle\ImportExportBundle\Exporter\CsvExporter');
    }

    function it_implements_exporter_interface()
    {
        $this->shouldImplement('Sylius\Component\ImportExport\Exporter\ExporterInterface');
    }
}
