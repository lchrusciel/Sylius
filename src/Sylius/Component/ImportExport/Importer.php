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

use Sylius\Component\ImportExport\Model\ImportProfile;
use Sylius\Component\Registry\ServiceRegistryInterface;

/**
 * @author Mateusz Zalewski <mateusz.zalewski@lakion.com>
 */
class Importer implements ImporterInterface
{
    /**
     * Importer registry
     *
     * @var ServiceRegistryInterface
     */
    private $readerRegistry;

    /**
     * Importer registry
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
    public function __construct(ServiceRegistryInterface $readerRegistry
        // , ServiceRegistryInterface $writerRegistry
        )
    {
        $this->readerRegistry = $readerRegistry;
        // $this->writerRegistry = $writerRegistry;
    }

    /**
     * {@inheritdoc}
     */
    public function import(ImportProfile $importProfile)
    {
        if (null === $type = $importProfile->getImporter()) {
            throw new \InvalidArgumentException('Cannot import data with ImportProfile instance without importer defined.');
        }
        $importer = $this->readerRegistry->get($type);
        return $importer->import($importProfile->getEntity(), $importProfile->getFields(), $importProfile->getImporterConfiguration());
    }
}