<?php

namespace Sylius\Component\Core\Distributor;

use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;

class MinimumPriceDistributor implements MinimumPriceDistributorInterface
{
    private ProportionalIntegerDistributorInterface $proportionalIntegerDistributor;

    public function __construct(ProportionalIntegerDistributorInterface $proportionalIntegerDistributor)
    {
        $this->proportionalIntegerDistributor = $proportionalIntegerDistributor;
    }
//Product 1: $10 without minimum price  10/110 * 1200 = 110 1000 => 890
//Product 2: $20 with minimum price $19 20/110 * 1200 = 218
//Product 3: $50 with minimum price $50 50/110 * 1200 = 545
//Product 4: $30 with minimum price $26 30/110 * 1200 = 327 3000 => 2673
// 110
//add to cart 1x Product 1, 1x Product 2, 1x Product 3 and 1x Product 4 and apply $12 discount

    public function distribute(array $orderItems, int $amount, $channel): array
    {
        $orderItemsToProcess = [];
        foreach ($orderItems as $orderItem) {
            $orderItemsToProcess[] = [
                'orderItem' => $orderItem,
                'currentlyDiscounted' => 0,
            ];
        }

        return array_map(function (array $processedOrderItem) { return $processedOrderItem['promotion']; }, $this->doDistribute($orderItemsToProcess, $amount, $channel));
    }

//    public function distributeWithMinimumPrice(int $promotionAmount, array $itemTotals, array $minimumPrices, $distributed = [], $toDistribute = []): array
//    {
////        array_multisort($minimumPrices, SORT_DESC, $itemTotals);
//
//        $splitPromotion = $this->proportionalIntegerDistributor->distribute($itemTotals, $promotionAmount);
//
//        $exceedsMinimumPrice = false;
////        $promotionAmountLeft = 0;
//        $minimumPrices2 = [];
//        $newDiscounts = [];
//        foreach ($splitPromotion as $key => $splitPromotionAmount) {
//            if ($itemTotals[$key] + $splitPromotionAmount <= $minimumPrices[$key] && $minimumPrices[$key] > 0 && $exceedsMinimumPrice === false) {
//                $availableAmount = $itemTotals[$key] - $minimumPrices[$key];
//                $splitPromotion[$key] = -$availableAmount;
//                $promotionAmount += $availableAmount;
////                $promotionAmountLeft += ($splitPromotionAmount + $availableAmount);
//                $distributed[] = $splitPromotion[$key];
//                $exceedsMinimumPrice = true;
//            } else {
//                $toDistribute[] = $itemTotals[$key];
//                $minimumPrices2[] = $minimumPrices[$key];
////                $promotionAmountLeft += $splitPromotionAmount;
//            }
//        }
//
//        if ($exceedsMinimumPrice === true && array_sum($toDistribute) > 0) {
//            return array_merge($distributed, $this->distributeWithMinimumPrice($promotionAmount, $toDistribute, $minimumPrices2));
////            return $this->merge($distributed, $this->distributeWithMinimumPrice($promotionAmount, $toDistribute, $minimumPrices2), $newDiscounts);
//
//        }
//
//        return $splitPromotion;
//    }


//    private function merge(array $distributed, array $splitPromotion, array $newDiscounts): array
//    {
////        $temp = array_merge($distributed, $splitPromotion);
//            $temp = $splitPromotion;
////        $retArr = [];
////
////        for ($x = 0; $x < sizeof($temp) + sizeof($newDiscounts); $x++) {
////            $value = $temp[$x];
////
////            if (isset($newDiscounts[$x])) {
////
////            }
////        }
////        return $temp;
//
//        foreach ($newDiscounts as $key => $newDiscount) {
//            array_splice($temp, $key, 0, $newDiscount);
//        }
//
//        return $temp;
//    }
    private function doDistribute(array $orderItems, int $amount, $channel): array
    {
        $totals = array_map(function (array $orderItemData) {
            return $orderItemData['orderItem']->getTotal();
        }, $orderItems);

        $promotionsToDistribute = $this->proportionalIntegerDistributor->distribute($totals, $amount);

        $rawDistribution = [];
        foreach ($promotionsToDistribute as $index => $promotion) {
            $rawDistribution[] = [
                'orderItem' => $orderItems[$index]['orderItem'],
                'currentlyDiscounted' => $orderItems[$index]['currentlyDiscounted'],
                'promotion' => $promotion,
            ];
        }

        // Dystrybucja pierwsza bez minimum price iteracja $orderItems = [$thsirt, $book, $shoes, $boardGame] => [
        //                'orderItem' => $thsirt,
        //                'promotion' => 110,
        //            ],
        //            [
        //                'orderItem' => $book,
        //                'promotion' => 218,
        //            ],
        //            [
        //                'orderItem' => $shoes,
        //                'promotion' => 545,
        //            ],
        //            [
        //                'orderItem' => $boardGame,
        //                'promotion' => 327,
        //            ]

        $leftAmount = 0;
        $distributableItems = [];
        $distributionsWithMinimalPriceTakenIntoAccount = [];
        foreach ($rawDistribution as $distribution) {
            $distributionWithMinimalPriceTakenIntoAccount = [];
            /** @var OrderItemInterface $orderItem */
            $orderItem = $distribution['orderItem'];
            /** @var ProductVariantInterface $variant */
            $variant = $orderItem->getVariant();

            $minimumPrice = $variant->getChannelPricingForChannel($channel)->getMinimumPrice();

            $minimumPrice *= $orderItem->getQuantity();
            $minimumPrice -= $distribution['currentlyDiscounted'];

            $distributionWithMinimalPriceTakenIntoAccount['orderItem'] = $distribution['orderItem'];

            if ($minimumPrice >= ($orderItem->getTotal() + $distribution['promotion'])) {
                $leftAmount -= ($orderItem->getTotal() + $distribution['promotion']) - ($minimumPrice);
                $distributionWithMinimalPriceTakenIntoAccount['promotion'] = $minimumPrice - $orderItem->getTotal();
            } else {
                $distributionWithMinimalPriceTakenIntoAccount['promotion'] = $distribution['promotion'];
                $distributableItems[] = [
                    'orderItem' => $orderItem,
                    'currentlyDiscounted' => $distribution['currentlyDiscounted'] + $distribution['promotion'],
                ];
            }

            $distributionsWithMinimalPriceTakenIntoAccount[] = $distributionWithMinimalPriceTakenIntoAccount;
        }
        // Dystrybucja pierwsza z uwzględnienie minimum price iteracja $orderItems = [$thsirt, $book, $shoes, $boardGame] => [
        //                'orderItem' => $thsirt,
        //                'promotion' => 110,
        //            ],
        //            [
        //                'orderItem' => $book,
        //                'promotion' => 100, reszty 118
        //            ],
        //            [
        //                'orderItem' => $shoes,
        //                'promotion' => 0, reszty 545
        //            ],
        //            [
        //                'orderItem' => $boardGame,
        //                'promotion' => 327
        //            ]
        // if leftAmount === 0 exit => leftAmount => 118 + 545 = 663

        // for $orderItems if !possibilityForPromotion remove from $distributableItems => [$thsirt, $boardGame]

        // if $orderItems empty exit

        if ($leftAmount === 0 || empty($distributableItems)) {
            return $distributionsWithMinimalPriceTakenIntoAccount;
        }

        $nestedDistributions = $this->doDistribute($distributableItems, $leftAmount, $channel);

        foreach ($distributionsWithMinimalPriceTakenIntoAccount as $index => $distribution) {
            foreach ($nestedDistributions as $nestedDistribution) {
                if ($distribution['orderItem'] === $nestedDistribution['orderItem']) {
                    $distributionsWithMinimalPriceTakenIntoAccount[$index]['promotion'] += $nestedDistribution['promotion'];
                }
            }
        }

        return $distributionsWithMinimalPriceTakenIntoAccount;

        // loop to distribute($distributableItems, $leftAmount)
//Product 1: $10 without minimum price  1000/4000 * 663 = 166
//Product 4: $30 with minimum price $26 3000/4000 * 663 = 497
        //         // Dystrybucja druga bez minimum price iteracja $orderItems = [$thsirt, $boardGame] => [
        //        //                'orderItem' => $thsirt,
        //        //                'promotion' => 166,
        //        //            ],
        //        //            [
        //        //                'orderItem' => $boardGame,
        //        //                'promotion' => 497
        //        //            ]

        //
        //        // Dystrybucja druga z uwzględnienie minimum price iteracja $orderItems = [$thsirt] => [
        //        //                'orderItem' => $thsirt,
        //        //                'promotion' => 166,
        //        //            ],
        //        //        //            [
        //        //        //                'orderItem' => $boardGame,
        //        //        //                'promotion' => 73
        //        //        //            ]

        //        // if leftAmount === 0 exit => leftAmount => 424

        // for $orderItems = [$thsirt, $book, $shoes, $boardGame] and $distributableItems = [
        //        //        //                'orderItem' => $thsirt,
        //        //        //                'promotion' => 890,
        //        //        //            ]
    }
}
