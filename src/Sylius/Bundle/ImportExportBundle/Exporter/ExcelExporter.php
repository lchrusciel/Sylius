<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\ImportExportBundle\Exporter;

use Doctrine\ORM\EntityManager;
use Sylius\Component\ImportExport\Exporter\ExporterInterface;
use Ddeboer\DataImport\Workflow;
use Ddeboer\DataImport\Reader\DoctrineReader;
use Ddeboer\DataImport\Writer\ExcelWriter;
use Ddeboer\DataImport\Filter\CallbackFilter;

/**
 * @author Mateusz Zalewski <mateusz.zalewski@lakion.com>
 */
class ExcelExporter implements ExporterInterface
{
    public function export($entity, array $fields, array $configuration)
    {
        $doctrineReader = new DoctrineReader($this->entityManager, $entity);
        $workflow = new Workflow($doctrineReader);

        $file = new \SplFileObject('data.xlsx', 'w');
        $excelWriter = new ExcelWriter($file);

        $callbackFilter = new CallbackFilter();

        return $workflow
               ->addWriter($excelWriter)
               ->addFilter($callbackFilter)
               ->process()
        ;
    }
}