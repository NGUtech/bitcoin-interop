<?php declare(strict_types=1);
/**
 * This file is part of the daikon-cqrs/bitcoin-interop project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Daikon\Bitcoin\Service;

use Money\Currency;
use Money\Exception\ParserException;
use Money\Money;
use Money\MoneyParser;

final class SatoshiMoneyParser implements MoneyParser
{
    /** @param null|Currency $forceCurrency */
    public function parse($money, $forceCurrency = null)
    {
        if (is_string($money) === false) {
            throw new ParserException('Formatted raw money should be string, e.g. 100SAT');
        }

        if (!preg_match('#^(?<amount>-?\d+)\s?(?<currency>M?SAT)$#', $money, $matches)) {
            throw new ParserException('Value cannot be parsed to Satoshi.');
        }

        $currency = $forceCurrency ?: new Currency($matches['currency']);

        return new Money($matches['amount'], $currency);
    }
}
