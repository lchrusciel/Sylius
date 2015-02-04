<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\ImportExportBundle\Form\Type\Exporter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Exporter choice choice type.
 *
 * @author Mateusz Zalewski <mateusz.zalewski@lakion.com>
 */
class CsvExporterType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', 'text', array(
                'label'    => 'sylius.form.exporter.csv.delimiter',
                'data'     => ';',
            ))
            ->add('enclosure', 'text', array(
                'label'    => 'sylius.form.exporter.csv.enclosure',
                'data'     => '"',
            ))
            ->add('add_header', 'checkbox', array(
                'label'    => 'sylius.form.exporter.csv.add_header',
                'required' => false,
            ))
            ->add('file', 'text', array(
                'label'    => 'sylius.form.exporter.file',
                'required' => true,
            ))
        ;
    }
}