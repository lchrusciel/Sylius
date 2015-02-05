<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\ImportExportBundle\Form\Type;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Bundle\ImportExportBundle\Form\EventListener\BuildExportListener;
use Sylius\Component\Registry\ServiceRegistryInterface;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Export profile form type.
 *
 * @author Łukasz Chruściel <lukasz.chrusciel@lakion.com>
 * @author Bartosz Siejka <bartosz.siejka@lakion.com>
 */
class ExportProfileType extends AbstractResourceType
{
    protected $exporterRegistry;

    public function __construct($dataClass, array $validationGroups, ServiceRegistryInterface $exporterRegistry)
    {
        parent::__construct($dataClass, $validationGroups);

        $this->exporterRegistry = $exporterRegistry;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addEventSubscriber(new BuildWriterFormListener($this->exporterRegistry, $builder->getFormFactory()))
            ->add('name', 'text', array(
                'label' => 'sylius.form.export_profile.name',
                'required' => true,
            ))
            ->add('code', 'text', array(
                'label'    => 'sylius.form.export_profile.code',
                'required' => true,
            ))
            ->add('description', 'textarea', array(
                'label'    => 'sylius.form.export_profile.description',
                'required' => false,
            ))
            ->add('writer', 'sylius_writer_choice', array(
                'label' => 'sylius.form.rule.exporter'
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sylius_export_profile';
    }
}
