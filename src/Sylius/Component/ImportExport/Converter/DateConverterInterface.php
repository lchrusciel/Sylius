<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Component\ImportExport\Converter;

/**
 * @author Łukasz Chruściel <lukasz.chrusciel@lakion.com>
 */
interface DateConverterInterface
{
    /**
     * Converts given \DateTime into string with following format.
     *
     * @param \DateTime $date
     * @param string $format
     *
     * @return string
     */
    public function toString(\DateTime $date, $format);
}