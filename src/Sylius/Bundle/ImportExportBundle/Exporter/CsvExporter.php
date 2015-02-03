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
use Ddeboer\DataImport\Writer\CsvWriter;
use Ddeboer\DataImport\Filter\CallbackFilter;
use Ddeboer\DataImport\ValueConverter\DateTimeToStringValueConverter;
/**
 * @author Mateusz Zalewski <mateusz.zalewski@lakion.com>
 */
class CsvExporter implements ExporterInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * Constructor
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function export($entity, array $fields, array $configuration)
    {
        $doctrineReader = new DoctrineReader($this->entityManager, $entity);
        $workflow = new Workflow($doctrineReader);

        $csvWriter = new CsvWriter();
        $csvWriter->setStream(fopen($configuration["file"], 'w'));

        $workflow->addWriter($csvWriter);

        $converter = new DateTimeToStringValueConverter();

        $workflow
               ->addValueConverter('available_on', $converter)
               ->addValueConverter('created_at', $converter)
               ->addValueConverter('updated_at', $converter)
               ->addValueConverter('deleted_at', $converter)
        ;

        return $workflow->process();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'csv';
    }
}