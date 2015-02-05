<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Component\ImportExport;

use Sylius\Component\ImportExport\Model\ExportProfileInterface;
use Sylius\Component\Registry\ServiceRegistryInterface;

/**
 * @author Mateusz Zalewski <mateusz.zalewski@lakion.com>
 */
class Exporter implements ExporterInterface
{
    /**
     * Reader registry
     *
     * @var ServiceRegistryInterface
     */
    private $readerRegistry;

    /**
     * Writer registry
     *
     * @var ServiceRegistryInterface
     */
    private $writerRegistry;

    /**
     * Constructor
     *
     * @var ServiceRegistryInterface $readerRegistry
     * @var ServiceRegistryInterface $writerRegistry
     */
    public function __construct(ServiceRegistryInterface $readerRegistry, ServiceRegistryInterface $writerRegistry)
    {
        $this->readerRegistry = $readerRegistry;
        $this->writerRegistry = $writerRegistry;
    }

    public function export(ExportProfileInterface $exportProfile)
    {
        if (null === $readerType = $exportProfile->getReader()) {
            throw new \InvalidArgumentException('Cannot write data with ExportProfile instance without writer defined.');
        }
        if (null === $writerType = $exportProfile->getWriter()) {
            throw new \InvalidArgumentException('Cannot write data with ExportProfile instance without writer defined.');
        }

        $reader = $this->readerRegistry->get($readerType);
        $reader->setConfiguration($exportProfile->getReaderConfiguration());

        $writer = $this->writerRegistry->get($writerType);
        $writer->setConfiguration($exportProfile->getWriterConfiguration());

        $writer->write($reader->read());
    }
}