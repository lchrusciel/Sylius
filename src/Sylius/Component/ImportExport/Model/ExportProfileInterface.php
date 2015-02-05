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
     * Gets the value of writer.
     *
     * @return string
     */
    public function getWriter();

    /**
     * Sets the value of writer.
     *
     * @param string $writer the writer
     *
     * @return self
     */
    public function setWriter($writer);

    /**
     * Gets the value of writerConfiguration.
     *
     * @return array
     */
    public function getWriterConfiguration();

    /**
     * Sets the value of writerConfiguration.
     *
     * @param array $writerConfiguration the exporter configuration
     *
     * @return self
     */
    public function setWriterConfiguration(array $writerConfiguration);
}