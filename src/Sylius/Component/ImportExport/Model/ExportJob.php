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
class ExportJob extends Job
{
    /**
     * @var ExportProfile
     */
    private $exportProfile;

    /**
     * Gets the value of exportProfile.
     *
     * @return ExportProfile
     */
    public function getExportProfile()
    {
        return $this->exportProfile;
    }

    /**
     * Sets the value of exportProfile.
     *
     * @param ExportProfile $exportProfile the export profile
     *
     * @return self
     */
    private function setExportProfile(ExportProfile $exportProfile)
    {
        $this->exportProfile = $exportProfile;

        return $this;
    }
}