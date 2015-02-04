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
    private $exporter = 'csv_exporter';

    /**
     * @var array
     */
    private $exporterConfiguration = array();

    /**
     * {@inheritdoc}
     */
    public function getExporter()
    {
        return $this->exporter;
    }

    /**
     * {@inheritdoc}
     */
    public function setExporter($exporter)
    {
        $this->exporter = $exporter;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getExporterConfiguration()
    {
        return $this->exporterConfiguration;
    }

    /**
     * {@inheritdoc}
     */
    public function setExporterConfiguration(array $exporterConfiguration)
    {
        $this->exporterConfiguration = $exporterConfiguration;

        return $this;
    }
}