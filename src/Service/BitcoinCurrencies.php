<?php declare(strict_types=1);
/**
 * This file is part of the ngutech/bitcoin-interop project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NGUtech\Bitcoin\Service;

use ArrayIterator;
use Money\Currencies;
use Money\Currency;
use Money\Exception\UnknownCurrencyException;
use Traversable;

final class BitcoinCurrencies implements Currencies
{
    public const BTC = 'BTC';
    public const XBT = 'XBT';

    public const SYMBOL = "\u{20BF}";

    public function contains(Currency $currency): bool
    {
        return in_array($currency->getCode(), [self::BTC, self::XBT]);
    }

    public function subunitFor(Currency $currency): int
    {
        if (!$this->contains($currency)) {
            throw new UnknownCurrencyException(
                $currency.' is not Bitcoin and is not supported by this currency repository.'
            );
        }

        return 8;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator([
            new Currency(self::BTC),
            new Currency(self::XBT),
        ]);
    }
}
