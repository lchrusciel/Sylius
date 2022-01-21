<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Sylius\Bundle\CoreBundle\Processor;

use Sylius\Component\Core\Event\ProductVariantsToUpdated;
use Sylius\Component\Core\Event\ProductVariantUpdated;
use Sylius\Component\Core\Repository\ProductVariantRepositoryInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class AllCatalogPromotionsProcessor implements AllCatalogPromotionsProcessorInterface
{
    public function __construct(
        private ProductVariantRepositoryInterface $productVariantRepository,
        private MessageBusInterface $messageBus
    ) {
    }

    public function process(): void
    {
        $codes = $this->productVariantRepository->createQueryBuilder('o')->select('o.code')->getQuery()->getArrayResult();

        $batchedCodes = array_chunk($codes, 580);
        foreach ($batchedCodes as $chunk) {
            $this->messageBus->dispatch(new ProductVariantsToUpdated(array_column($chunk, 'code')));
        }
    }
}
