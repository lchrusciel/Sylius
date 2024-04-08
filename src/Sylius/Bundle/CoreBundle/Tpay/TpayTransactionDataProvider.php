<?php

declare(strict_types=1);

namespace Sylius\Bundle\CoreBundle\Tpay;

use Sylius\Component\Core\Model\Customer;
use Sylius\Component\Core\Model\Order;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Payment\Model\PaymentRequestInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Webmozart\Assert\Assert;

final class TpayTransactionDataProvider
{
    public function __construct(
        private readonly UrlGeneratorInterface $router,
        private readonly TranslatorInterface $translator,
    ) {
    }

    public function getTransactionData(PaymentRequestInterface $paymentRequest): array
    {
        $payment = $paymentRequest->getPayment();
        /** @var Order $order */
        $order = $payment->getOrder();
        Assert::isInstanceOf($order, OrderInterface::class);

        /** @var Customer $customer */
        $customer = $order->getCustomer();
        $orderToken = $order->getTokenValue();

        return [
            'amount' => $order->getTotal() / 100,
            'description' => sprintf(
                '%s %s',
                $this->translator->trans('app.payment.order_number'),
                $order->getNumber(),
            ),
            'hiddenDescription' => sprintf(
                '%s: %s',
                $this->translator->trans('app.payment.order_link'),
                $this->generateAbsoluteUrl('sylius_admin_order_show', ['id' => $order->getId()]),
            ),
            'payer' => [
                'email' => $customer->getEmail(),
                'name' => $order->getBillingAddress()?->getFullName() ?? '',
            ],
            'callbacks' => [
                'notification' => [
                    'url' => $this->generateAbsoluteUrl('api_payment_requests_shop_put_item', [
                        'hash' => $paymentRequest->getHash(),
                    ]),
                ],
                'payerUrls' => [
                    'success' => $this->generateAbsoluteUrl('sylius_shop_order_thank_you', ['tokenValue' => $orderToken, '_locale' => $order->getLocaleCode()]),
                    'error' => $this->generateAbsoluteUrl('sylius_shop_order_show', ['tokenValue' => $orderToken, '_locale' => $order->getLocaleCode()]),
                ],
            ],
        ];
    }

    /** @param array<string, mixed> $parameters */
    private function generateAbsoluteUrl(string $route, array $parameters): string
    {
        return $this->router->generate($route, $parameters, UrlGeneratorInterface::ABSOLUTE_URL);
    }
}
