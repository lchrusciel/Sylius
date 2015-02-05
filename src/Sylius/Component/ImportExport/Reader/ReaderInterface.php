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

/**
 * @author Łukasz Chruściel <lukasz.chrusciel@lakion.com>
 */
interface ReaderInterface
{
    /**
     * {@inheritdoc}
     */
    public function read();

    /**
     * @param array $configuration
     */
    public function setConfiguration(array $configuration);
}