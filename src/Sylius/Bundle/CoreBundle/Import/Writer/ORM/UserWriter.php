<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\CoreBundle\Import\Writer\ORM;

use Sylius\Component\Resource\Repository\RepositoryInterface;
use Doctrine\ORM\EntityManager;

/**
 * User writer.
 *
 * @author Bartosz Siejka <bartosz.siejka@lakion.com>
 */
class UserWriter extends AbstractDoctrineWriter
{
    private $userRepository;
    
    public function __construct(RepositoryInterface $userRepository, EntityManager $em)
    {
        parent::__construct($em);
        $this->userRepository = $userRepository;
    }
    
    public function process($data) 
    {
        $user = $this->userRepository->createNew();
        $shippingAddress = $user->getShippingAddress();
        $billingAddress = $user->getBillingAddress();
        
        $user->setFirstName($data['first_name']);
        $user->setLastName($data['last_name']);
        $user->setEmail($data['email']);
//        $user->setUsername($data['username']);
        $shippingAddress ? $shippingAddress->setCompany($data['shipping_address_company']) : null;
        $shippingAddress ? $shippingAddress->setCountry($data['shipping_address_country']) : null;
        $shippingAddress ? $shippingAddress->setProvince($data['shipping_address_province']) : null;
        $shippingAddress ? $shippingAddress->setCity($data['shipping_address_city']) : null;
        $shippingAddress ? $shippingAddress->setStreet($data['shipping_address_street']) : null;
        $shippingAddress ? $shippingAddress->setPostcode($data['shipping_address_postcode']) : null;
        $shippingAddress ? $shippingAddress->setPhoneNumber($data['shipping_address_phone_number']) : null;
        $billingAddress ? $billingAddress->setCompany($data['billing_address_company']) : null;
        $billingAddress ? $billingAddress->setCountry($data['billing_address_country']) : null;
        $billingAddress ? $billingAddress->setProvince($data['billing_address_province']) : null;
        $billingAddress ? $billingAddress->setCity($data['billing_address_city']) : null;
        $billingAddress ? $billingAddress->setStreet($data['billing_address_street']) : null;
        $billingAddress ? $billingAddress->setPostcode($data['billing_address_postcode']) : null;
        $billingAddress ? $billingAddress->setPhoneNumber($data['billing_address_phone_number']) : null;
        $user->setEnabled($data['enabled']);
        $user->setCurrency($data['currency']);
        $user->setPlainPassword($data['password']);
        $user->setCreatedAt(new \DateTime($data['created_at']));
        
        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'import_user';
    }
}