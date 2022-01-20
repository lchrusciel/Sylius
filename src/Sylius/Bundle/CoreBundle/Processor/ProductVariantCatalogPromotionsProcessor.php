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

use Sylius\Bundle\CoreBundle\Applicator\CatalogPromotionApplicatorInterface;
use Sylius\Bundle\CoreBundle\Provider\ForTaxonsScopeVariantsProvider;
use Sylius\Bundle\PromotionBundle\Provider\EligibleCatalogPromotionsProviderInterface;
use Sylius\Component\Core\Model\CatalogPromotionInterface;
use Sylius\Component\Core\Model\ChannelPricingInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Core\Model\TaxonInterface;

final class ProductVariantCatalogPromotionsProcessor implements ProductVariantCatalogPromotionsProcessorInterface
{
    public function __construct(
        private CatalogPromotionClearerInterface $catalogPromotionClearer,
        private CatalogPromotionApplicatorInterface $catalogPromotionApplicator
    ) {
    }

    public function process(ProductVariantInterface $variant, array $catalogPromotions): void
    {
        $this->catalogPromotionClearer->clearVariant($variant);

        foreach ($catalogPromotions as $catalogPromotion) {
            $scopes = $catalogPromotion->getScopes();

            foreach ($scopes as $scope) {
                if ($scope->getType() === ForTaxonsScopeVariantsProvider::TYPE) {
                    /** @var ProductInterface $product */
                    $product = $variant->getProduct();

                    if (!$product->getTaxons()->exists(
                        fn(int $key, TaxonInterface $taxon): bool => \in_array($taxon->getCode(), $scope->getConfiguration()['taxons'])
                    )) {
                        continue 2;
                    }
                }

                $this->catalogPromotionApplicator->applyOnVariant($variant, $catalogPromotion);
            }
        }
    }
}
