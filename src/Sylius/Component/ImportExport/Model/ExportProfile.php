<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Component\ImportExport\Model;

/**
 * @author Mateusz Zalewski <mateusz.zalewski@lakion.com>
 */
class ExportProfile extends Profile implements ExportProfileInterface
{
    /**
     * @var string
     */
    private $writer = 'csv_writer';

    /**
     * @var array
     */
    private $writerConfiguration = array();

    /**
     * {@inheritdoc}
     */
    public function getWriter()
    {
        return $this->writer;
    }

    /**
     * {@inheritdoc}
     */
    public function setWriter($writer)
    {
        $this->writer = $writer;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getWriterConfiguration()
    {
        return $this->writerConfiguration;
    }

    /**
     * {@inheritdoc}
     */
    public function setWriterConfiguration(array $writerConfiguration)
    {
        $this->writerConfiguration = $writerConfiguration;

        return $this;
    }
}