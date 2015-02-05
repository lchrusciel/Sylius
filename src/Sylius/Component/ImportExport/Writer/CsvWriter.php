<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Component\ImportExport\Writer;

use Doctrine\ORM\EntityManager;
use EasyCSV\Writer;

/**
 * @author Mateusz Zalewski <mateusz.zalewski@lakion.com>
 */
class CsvWriter implements WriterInterface
{
    /**
     * Is EasySCV\Writer initialized
     *
     * @var boolean
     */
    private $running = false;

    /**
     * @var Writer
     */
    private $csvWriter;

    public function write(array $items, array $configuration)
    {
        if (!$this->running) {
            $this->csvWriter = new Writer($configuration["file"], 'w');
        }

        $this->csvWriter->writeFromArray($items);
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'csv';
    }
}