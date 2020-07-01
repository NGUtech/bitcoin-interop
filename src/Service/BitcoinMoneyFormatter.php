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

final class BitcoinMoneyFormatter implements MoneyFormatter
{
    private Currencies $currencies;

    public function __construct(Currencies $currencies)
    {
        $this->currencies = $currencies;
    }

    public function format(Money $money): string
    {
        $currency = $money->getCurrency();
        if (!$this->currencies->contains($currency)) {
            throw new FormatterException('Bitcoin formatter can only format Bitcoin currencies.');
        }

        $valueBase = $money->getAmount();
        $negative = false;

        if ('-' === $valueBase[0]) {
            $negative = true;
            $valueBase = substr($valueBase, 1);
        }

        $subunit = $this->currencies->subunitFor($currency);
        $valueLength = strlen($valueBase);

        if ($valueLength > $subunit) {
            $formatted = substr($valueBase, 0, $valueLength - $subunit);
            if ($subunit) {
                $formatted .= '.';
                $formatted .= substr($valueBase, $valueLength - $subunit);
            }
        } else {
            $formatted = '0.'.str_pad('', $subunit - $valueLength, '0').$valueBase;
        }

        $formatted = BitcoinCurrencies::SYMBOL.$formatted;
        $formatted = $negative === true ? '-'.$formatted : $formatted;

        return $formatted;
    }
}
