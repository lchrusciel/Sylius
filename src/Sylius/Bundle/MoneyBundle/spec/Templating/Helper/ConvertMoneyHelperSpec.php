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

namespace spec\Sylius\Bundle\MoneyBundle\Templating\Helper;

use PhpSpec\ObjectBehavior;
use Sylius\Bundle\MoneyBundle\Templating\Helper\ConvertMoneyHelperInterface;
use Sylius\Component\Currency\Converter\CurrencyConverterInterface;

final class ConvertMoneyHelperSpec extends ObjectBehavior
{
    function let(CurrencyConverterInterface $currencyConverter): void
    {
        $this->beConstructedWith($currencyConverter);
    }

    function it_is_a_convert_money_price_helper(): void
    {
        $this->shouldImplement(ConvertMoneyHelperInterface::class);
    }

    function it_converts_and_formats_money_using_default_locale_if_not_given(
        CurrencyConverterInterface $currencyConverter,
    ): void {
        $currencyConverter->convert(500, 'USD', 'CAD')->willReturn(250);

        $this->convertAmount(500, 'USD', 'CAD')->shouldReturn('250');
    }
}
