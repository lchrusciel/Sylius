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

/**
 * @author Mateusz Zalewski <mateusz.zalewski@lakion.com>
 */
class ExcelWriter implements WriterInterface
{
    public function write(array $items, array $configuration)
    {
        
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'excel';
    }
}