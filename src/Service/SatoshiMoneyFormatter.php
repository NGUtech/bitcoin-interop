<?php declare(strict_types=1);
/**
 * This file is part of the daikon-cqrs/bitcoin-interop project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Daikon\Bitcoin\Service;

use Money\Currencies;
use Money\Exception\FormatterException;
use Money\Money;
use Money\MoneyFormatter;

final class SatoshiMoneyFormatter implements MoneyFormatter
{
    private Currencies $currencies;

    public function __construct(Currencies $currencies)
    {
        $this->currencies = $currencies;
    }

    public function format(Money $money): string
    {
        if (!$this->currencies->contains($money->getCurrency())) {
            throw new FormatterException('Satoshi formatter can only format Satoshi currencies.');
        }

        return $money->getAmount().SatoshiCurrencies::MSAT_CODE;
    }
}
