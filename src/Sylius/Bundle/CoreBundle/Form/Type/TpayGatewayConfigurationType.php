<?php

declare(strict_types=1);

namespace Sylius\Bundle\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class TpayGatewayConfigurationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('client_id', TextType::class, [
                'label' => 'sylius.form.gateway_configuration.client_id',
            ])
            ->add('client_secret', TextType::class, [
                'label' => 'sylius.form.gateway_configuration.client_secret',
            ])
            ->add('merchant_security_code', TextType::class, [
                'label' => 'sylius.form.gateway_configuration.merchant_security_code',
            ])
            ->add('production_mode', CheckboxType::class, [
                'label' => 'sylius.form.gateway_configuration.product_mode',
            ])
        ;
    }
}
