<?php declare(strict_types=1);
/**
 * This file is part of the daikon-cqrs/bitcoin-interop project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Daikon\Bitcoin\ValueObject;

use Daikon\Bitcoin\Service\BitcoinCurrencies;
use Daikon\Bitcoin\Service\SatoshiCurrencies;
use Daikon\Interop\Assertion;
use Daikon\Interop\InvalidArgumentException;
use Daikon\Interop\MakeEmptyInterface;
use Daikon\Money\ValueObject\MoneyInterface;
use Money\Currency;
use Money\Money;

final class Bitcoin implements MakeEmptyInterface, MoneyInterface
{
    private Money $money;

    /** @param self $comparator */
    public function equals($comparator): bool
    {
        Assertion::isInstanceOf($comparator, self::class);
        return $this->toNative() === $comparator->toNative();
    }

    public function getAmount(): string
    {
        return $this->money->getAmount();
    }

    public function getCurrency(): string
    {
        return $this->money->getCurrency()->getCode();
    }

    public function multiply($multiplier, int $roundingMode = self::ROUND_HALF_UP): self
    {
        Assertion::numeric($multiplier, 'Multipler must be numeric.');
        $multiplied = $this->money->multiply($multiplier, $roundingMode);
        return new self($multiplied);
    }

    public function divide($divisor, int $roundingMode = self::ROUND_HALF_UP): self
    {
        Assertion::numeric($divisor, 'Divider must be numeric.');
        $divided = $this->money->divide($divisor, $roundingMode);
        return new self($divided);
    }

    public function percentage($percentage, int $roundingMode = self::ROUND_HALF_UP): self
    {
        return $this->multiply($percentage)->divide(100, $roundingMode);
    }

    public function add(MoneyInterface $money): self
    {
        $added = $this->money->add(
            self::asBaseMoney($money->getAmount(), $money->getCurrency())
        );
        return new self($added);
    }

    public function subtract(MoneyInterface $money): self
    {
        $subtracted = $this->money->subtract(
            self::asBaseMoney($money->getAmount(), $money->getCurrency())
        );
        return new self($subtracted);
    }

    public function isZero(): bool
    {
        return $this->money->isZero();
    }

    public function isPositive(): bool
    {
        return $this->money->isPositive();
    }

    public function isNegative(): bool
    {
        return $this->money->isNegative();
    }

    public function isLessThanOrEqual(MoneyInterface $money): bool
    {
        return $this->money->lessThanOrEqual(
            self::asBaseMoney($money->getAmount(), $money->getCurrency())
        );
    }

    public function isGreaterThanOrEqual(MoneyInterface $money): bool
    {
        return $this->money->greaterThanOrEqual(
            self::asBaseMoney($money->getAmount(), $money->getCurrency())
        );
    }

    /** @param string $value */
    public static function fromNative($value): self
    {
        Assertion::string($value, 'Must be a string.');

        if (!preg_match('/^(?<amount>-?\d+)\s?(?<currency>M?SAT|BTC|XBT)$/', $value, $matches)) {
            throw new InvalidArgumentException('Invalid amount.');
        }

        return new self(self::asBaseMoney($matches['amount'], $matches['currency']));
    }

    public static function zero($currency = null): self
    {
        return self::fromNative('0'.($currency ?? SatoshiCurrencies::MSAT));
    }

    public static function makeEmpty(): self
    {
        return self::zero();
    }

    public function isEmpty(): bool
    {
        return $this->isZero();
    }

    public function toNative(): string
    {
        return $this->getAmount().$this->getCurrency();
    }

    public function __toString(): string
    {
        return $this->toNative();
    }

    private static function asBaseMoney(string $amount, string $currency): Money
    {
        return new Money($amount, new Currency($currency));
    }

    private function __construct(Money $money)
    {
        Assertion::choice((string)$money->getCurrency(), [
            SatoshiCurrencies::MSAT,
            SatoshiCurrencies::SAT,
            BitcoinCurrencies::BTC,
            BitcoinCurrencies::XBT
        ], 'Invalid currency');
        $this->money = $money;
    }
}
