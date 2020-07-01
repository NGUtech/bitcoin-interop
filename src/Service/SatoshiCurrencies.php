<?php declare(strict_types=1);
/**
 * This file is part of the daikon-cqrs/bitcoin-interop project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Daikon\Bitcoin\Service;

use ArrayIterator;
use Money\Currencies;
use Money\Currency;
use Money\Exception\UnknownCurrencyException;
use Traversable;

final class SatoshiCurrencies implements Currencies
{
    public const SAT_CODE = 'SAT';
    public const MSAT_CODE = 'MSAT';

    public const SYMBOL = '';

    public function contains(Currency $currency): bool
    {
        return in_array($currency->getCode(), [self::SAT_CODE, self::MSAT_CODE]);
    }

    public function subunitFor(Currency $currency): int
    {
        if (!$this->contains($currency)) {
            throw new UnknownCurrencyException(
                $currency.' is not Satoshi and is not supported by this currency repository.'
            );
        }

        return 0;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator([
            new Currency(self::SAT_CODE),
            new Currency(self::MSAT_CODE)
        ]);
    }
}
