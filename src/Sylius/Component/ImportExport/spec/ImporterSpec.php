<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Sylius\Component\ImportExport;

use PhpSpec\ObjectBehavior;
use Sylius\Component\Registry\ServiceRegistryInterface;
use Sylius\Component\ImportExport\Model\ImportProfile;
use Sylius\Component\ImportExport\Writer\WriterInterface;
use Sylius\Component\ImportExport\Reader\ReaderInterface;

/**
 * @author Łukasz Chruściel <lukusz.chrusciel@lakion.com>
 */
class ImporterSpec extends ObjectBehavior
{
    function let(ServiceRegistryInterface $readerRegistry, ServiceRegistryInterface $writerRegistry)
    {
        $this->beConstructedWith($readerRegistry, $writerRegistry);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Sylius\Component\ImportExport\Importer');
    }

    function it_implements_delegating_importer_interface()
    {
        $this->shouldImplement('Sylius\Component\ImportExport\ImporterInterface');
    }

    function it_does_not_allow_to_import_data_without_reader_defined(ImportProfile $importProfile)
    {
        $importProfile->getReader()->willReturn(null);
        $this->shouldThrow(new \InvalidArgumentException('Cannot read data with ImportProfile instance without reader defined.'))
        ->duringImport($importProfile);
    }

    function it_does_not_allow_to_import_data_without_writer_defined(ImportProfile $importProfile)
    {
        $importProfile->getReader()->willReturn('csv_reader');
        $importProfile->getWriter()->willReturn(null);
        $this->shouldThrow(new \InvalidArgumentException('Cannot write data with ImportProfile instance without writer defined.'))
        ->duringImport($importProfile);
    }
}