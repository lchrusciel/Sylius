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

use Sylius\Component\ImportExport\Model\ExportProfile;
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

    public function export(ExportProfile $exportProfile)
    {
        if (null === $type = $exportProfile->getExporter()) {
            throw new \InvalidArgumentException('Cannot export data with ExportProfile instance without exporter defined.');
        }
        $exporter = $this->registry->get($type);
        return $exporter->export($exportProfile->getEntity(), $exportProfile->getFields(), $exportProfile->getExporterConfiguration());
    }
}