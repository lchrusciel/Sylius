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

namespace Sylius\Bundle\CoreBundle\Listener;

use Doctrine\ORM\EntityManagerInterface;
use Sylius\Bundle\CoreBundle\Processor\ProductVariantCatalogPromotionsProcessorInterface;
use Sylius\Bundle\PromotionBundle\Provider\EligibleCatalogPromotionsProviderInterface;
use Sylius\Component\Core\Event\ProductVariantsToUpdated;
use Sylius\Component\Core\Event\ProductVariantUpdated;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Core\Repository\ProductVariantRepositoryInterface;

final class ProductVariantUpdatedListener
{
    public function __construct(
        private ProductVariantRepositoryInterface $productVariantRepository,
        private ProductVariantCatalogPromotionsProcessorInterface $productVariantCatalogPromotionsProcessor,
        private EntityManagerInterface $entityManager,
        private EligibleCatalogPromotionsProviderInterface $catalogPromotionsProvider,
        private iterable $defaultCriteria = []
    ) {
    }

    public function __invoke(ProductVariantsToUpdated $event): void
    {
        /** @var ProductVariantInterface|null $variant */
        $variants = $this->productVariantRepository->findBy(['code' => $event->codes]);
        if ($variants === null) {
            return;
        }

        $catalogPromotions = $this->catalogPromotionsProvider->provide($this->defaultCriteria);

        foreach ($variants as $variant) {
            $this->productVariantCatalogPromotionsProcessor->process($variant, $catalogPromotions);
        }

        $this->entityManager->flush();
        $this->entityManager->clear();
    }
}
