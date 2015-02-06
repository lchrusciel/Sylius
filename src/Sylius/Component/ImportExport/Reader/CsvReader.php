<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Component\ImportExport\Reader;

use Doctrine\ORM\EntityManager;
use EasyCSV\Reader;

/**
 * Csv import reader
 *
 * @author Mateusz Zalewski <mateusz.zalewski@lakion.com>
 */
class CsvReader implements ReaderInterface
{
    /**
     * @var Reader
     */
    private $csvReader;

    /**
     * @var array
     */
    private $configuration;

    /**
     * {@inheritdoc}
     */
    public function read()
    {
        $this->csvReader = new Reader($this->configuration['file'], 'r', $this->configuration["headers"]);
        $this->csvReader->setDelimiter($this->configuration['delimiter']);
        $this->csvReader->setEnclosure($this->configuration['enclosure']);
        
        return $this->csvReader->getAll();
    }

    /**
     * {@inheritdoc}
     */
    public function setConfiguration(array $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'csv';
    }
}