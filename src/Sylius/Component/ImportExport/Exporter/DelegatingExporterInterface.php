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

/**
 * @author Mateusz Zalewski <zaleslaw@.gmail.com>
 */
interface DelegatingExporterInterface
{
    /**
     *
     * @param ExporterInterface $exporter
     * @param Data              $data
     *
     * @return integer
     */
    public function export(ExportProfile $exporter);
}