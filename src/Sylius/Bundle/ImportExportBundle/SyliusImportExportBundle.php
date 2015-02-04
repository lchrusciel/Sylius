<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\ImportExportBundle;

use Sylius\Bundle\ResourceBundle\AbstractResourceBundle;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use Sylius\Bundle\ImportExportBundle\DependencyInjection\Compiler\RegisterExportersPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Import/export component for Symfony2 applications.
 * It is used as a base for importing and exporting data.
 *
 * It is fully decoupled, so you can integrate it into your existing project.
 *
 * @author Bartosz Siejka <bartosz.siejka@lakion.com>
 * @author Łukasz Chruściel <lukasz.chrusciel@lakion.com>
 */
class SyliusImportExportBundle extends AbstractResourceBundle
{
    /**
     * {@inheritdoc}
     */
    public static function getSupportedDrivers()
    {
        return array(
            SyliusResourceBundle::DRIVER_DOCTRINE_ORM,
        );
    }

    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new RegisterExportersPass());
    }

    /**
     * {@inheritdoc}
     */
    protected function getModelInterfaces()
    {
        return array(
            'Sylius\Component\ImportExport\Model\ProfileInterface'  => 'sylius.model.import_export.profile.class',
            'Sylius\Component\ImportExport\Model\ExporterInterface' => 'sylius.model.import_export.exporter.class',
            'Sylius\Component\ImportExport\Model\JobInterface'      => 'sylius.model.import_export.job.class'
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getModelNamespace()
    {
        return 'Sylius\Component\ImportExport\Model';
    }
}
