<?php declare(strict_types=1);
/**
 * This file is part of the ngutech/bitcoin-interop project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NGUtech\Bitcoin\Service;

use Money\Currencies;
use Money\Currency;
use Money\Exception\ParserException;
use Money\Money;
use Money\MoneyParser;

final class BitcoinMoneyParser implements MoneyParser
{
    private Currencies $currencies;

    public function __construct(Currencies $currencies)
    {
        $this->currencies = $currencies;
    }

    /** @param null|Currency $forceCurrency */
    public function parse($money, $forceCurrency = null)
    {
        if (is_string($money) === false) {
            throw new ParserException('Formatted raw money should be string, e.g. ₿0.1');
        }

        $regex = '/^(?<amount>-?(?<symbol>[₿฿Ƀ])?\d+(?:\.\d+)?)\s?(?<currency>BTC|XBT)?$/iu';
        if (!preg_match($regex, $money, $matches)) {
            throw new ParserException('Value cannot be parsed as Bitcoin.');
        }

        if (!isset($matches['symbol']) && !isset($matches['currency'])) {
            throw new ParserException('Value currency cannot be parsed as Bitcoin.');
        }

        $currency = $forceCurrency ?: new Currency(strtoupper($matches['currency'] ?? BitcoinCurrencies::BTC));

        $amount = preg_replace('/[₿฿Ƀ]/u', '', $matches['amount']);
        $subunit = $this->currencies->subunitFor($currency);
        $decimalSeparator = strpos($amount, '.');

        if (false !== $decimalSeparator) {
            $amount = rtrim($amount, '0');
            $lengthAmount = strlen($amount);
            $amount = str_replace('.', '', $amount);
            $amount .= str_pad('', ($lengthAmount - $decimalSeparator - $subunit - 1) * -1, '0');
        } else {
            $amount .= str_pad('', $subunit, '0');
        }

        if (substr($amount, 0, 1) === '-') {
            $amount = '-'.ltrim(substr($amount, 1), '0');
        } else {
            $amount = ltrim($amount, '0');
        }

        if ('' === $amount) {
            $amount = '0';
        }

        return new Money($amount, $currency);
    }
}
