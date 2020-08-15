<?php declare(strict_types=1);
/**
 * This file is part of the ngutech/bitcoin-interop project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NGUtech\Bitcoin\ValueObject;

use Daikon\Interop\Assertion;
use Daikon\Interop\MakeEmptyInterface;
use Daikon\ValueObject\ValueObjectInterface;

final class Address implements MakeEmptyInterface, ValueObjectInterface
{
    private string $address;

    /** @param string|null $value */
    public static function fromNative($value): self
    {
        //@todo improve address validation
        Assertion::nullOrString($value, 'Must be a string.');
        return is_null($value) ? new self : new self($value);
    }

    public static function makeEmpty(): self
    {
        return new self;
    }

    public function isEmpty(): bool
    {
        return $this->address === '';
    }

    /** @param self $comparator */
    public function equals($comparator): bool
    {
        Assertion::isInstanceOf($comparator, self::class);
        return $this->toNative() === $comparator->toNative();
    }

    public function toNative(): string
    {
        return $this->address;
    }

    public function __toString(): string
    {
        return (string)$this->address;
    }

    private function __construct(string $address = '')
    {
        $this->address = $address;
    }
}
