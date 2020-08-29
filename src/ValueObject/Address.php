<?php declare(strict_types=1);
/**
 * This file is part of the ngutech/bitcoin-interop project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NGUtech\Bitcoin\ValueObject;

use Daikon\Interop\Assert;
use Daikon\Interop\Assertion;
use Daikon\Interop\MakeEmptyInterface;
use Daikon\ValueObject\ValueObjectInterface;

final class Address implements MakeEmptyInterface, ValueObjectInterface
{
    private ?string $address;

    /** @param string|null $value */
    public static function fromNative($value): self
    {
        //@todo improve bitcoin address validation
        Assert::that($value, 'Must be a valid string.')->nullOr()->string()->notBlank();
        return new self($value);
    }

    public static function makeEmpty(): self
    {
        return new self;
    }

    public function isEmpty(): bool
    {
        return $this->address === null;
    }

    /** @param self $comparator */
    public function equals($comparator): bool
    {
        Assertion::isInstanceOf($comparator, self::class);
        return $this->toNative() === $comparator->toNative();
    }

    public function toNative(): ?string
    {
        return $this->address;
    }

    public function __toString(): string
    {
        return (string)$this->address;
    }

    private function __construct(?string $address = null)
    {
        $this->address = $address;
    }
}
