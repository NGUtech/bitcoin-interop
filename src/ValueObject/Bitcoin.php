<?php declare(strict_types=1);
/**
 * This file is part of the ngutech/bitcoin-interop project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NGUtech\Bitcoin\ValueObject;

use Daikon\Interop\Assertion;
use Daikon\Interop\InvalidArgumentException;
use Daikon\Money\ValueObject\Money;
use NGUtech\Bitcoin\Service\SatoshiCurrencies;

final class Bitcoin extends Money
{
    /** @param null|string $value */
    public static function fromNative($value): self
    {
        Assertion::nullOrString($value, 'Must be a string.');
        if ($value === null) {
            return new self;
        }

        if (!preg_match('/^(?<amount>-?\d+)\s?(?<currency>M?SAT|BTC|XBT)$/i', $value, $matches)) {
            throw new InvalidArgumentException('Invalid amount.');
        }

        return new self(self::asBaseMoney($matches['amount'], strtoupper($matches['currency'])));
    }

    public static function zero($currency = null): self
    {
        return self::fromNative('0'.($currency ?? SatoshiCurrencies::MSAT));
    }
}
