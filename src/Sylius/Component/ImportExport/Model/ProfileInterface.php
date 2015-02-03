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
interface ProfileInterface
{
    public function getId();
    public function getName();
    public function setName($name);
    public function getCode();
    public function setCode($code);
    public function getDescription();
    public function setDescription($description);
    public function getEntity();
    public function setEntity($entity);
    public function getFields();
    public function setFields(array $fields);
}