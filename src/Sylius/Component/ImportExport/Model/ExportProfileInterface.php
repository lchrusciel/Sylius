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
interface ExportProfileInterface extends ProfileInterface
{

    /**
     * Gets the value of exporter.
     *
     * @return string
     */
    public function getExporter();

    /**
     * Sets the value of exporter.
     *
     * @param string $exporter the exporter
     *
     * @return self
     */
    public function setExporter($exporter);

    /**
     * Gets the value of exporterConfiguration.
     *
     * @return array
     */
    public function getExporterConfiguration();

    /**
     * Sets the value of exporterConfiguration.
     *
     * @param array $exporterConfiguration the exporter configuration
     *
     * @return self
     */
    public function setExporterConfiguration(array $exporterConfiguration);
}