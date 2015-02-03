<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Component\ImportExport\Exporter;

use Sylius\Component\ImportExport\Model\ExporterInterface;
use Sylius\Component\Registry\ServiceRegistryInterface;

/**
 * @author Mateusz Zalewski <mateusz.zalewski@lakion.com>
 */
class DelegatingExporter implements DelegatingExporterInterface
{
    /**
     * Exporter registry
     *
     * @var ServiceRegistryInterface
     */
    private $registry;

    /**
     * Constructor
     *
     * @var ServiceRegistryInterface $registry
     */
    public function __construct(ServiceRegistryInterface $registry)
    {
        $this->registry = $registry;
    }

    public function export(ExporterInterface $exporter)
    {
        if (null === $type = $exporter->getExporter()) {
            throw new \InvalidArgumentException('Cannot export data with ExporterInterface instance without exporter defined.');
        }
        $exporter = $this->registry->get($type);
        return $exporter->export($exporter->getEntity(), $exporter->getFields(), $exporter->getExporterConfiguration());
    }
}