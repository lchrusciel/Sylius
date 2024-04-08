<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Sylius Sp. z o.o.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Sylius\Bundle\CoreBundle\PaymentRequest\CommandHandler\TPay;

use Doctrine\Persistence\ObjectManager;
use Sylius\Bundle\CoreBundle\PaymentRequest\Command\TPay\CapturePaymentRequest;
use Sylius\Bundle\CoreBundle\PaymentRequest\Provider\PaymentRequestProviderInterface;
use Sylius\Bundle\CoreBundle\Tpay\TpayApiProvider;
use Sylius\Bundle\CoreBundle\Tpay\TpayTransactionDataProvider;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Tpay\OpenApi\Api\TpayApi;

/** @experimental */
final class CapturePaymentRequestHandler implements MessageHandlerInterface
{
    public function __construct(
        private readonly PaymentRequestProviderInterface $paymentRequestProvider,
        private readonly TpayApiProvider $tpayApiProvider,
        private readonly TpayTransactionDataProvider $tpayTransactionDataProvider,
        private readonly ObjectManager $objectManager,
    ) {
    }

    public function __invoke(CapturePaymentRequest $capturePaymentRequest): void
    {
        $paymentRequest = $this->paymentRequestProvider->provide($capturePaymentRequest);

        $transactionData = $this->tpayTransactionDataProvider->getTransactionData($paymentRequest);

        /** @var TpayApi $api */
        $api = $this->tpayApiProvider->getApi($paymentRequest->getPayment()->getMethod()->getGatewayConfig());

        $paymentRequest->setPayload($api->transactions()->createTransaction($transactionData));

        $this->objectManager->flush();
    }
}
