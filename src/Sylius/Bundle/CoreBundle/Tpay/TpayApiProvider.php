<?php

declare(strict_types=1);

namespace Sylius\Bundle\CoreBundle\Tpay;

use Sylius\Bundle\PayumBundle\Model\GatewayConfigInterface;
use Tpay\OpenApi\Api\TpayApi;

final class TpayApiProvider
{
    public function getApi(GatewayConfigInterface $gatewayConfig): TpayApi
    {
        $config = $gatewayConfig->getConfig();
        if (!isset($config['client_id'], $config['client_secret'], $config['production_mode'])) {
            throw new \InvalidArgumentException('Tpay gateway is not properly configured');
        }

        return new TpayApi(
            $config['client_id'],
            $config['client_secret'],
            $config['production_mode'],
        );
    }

}
