<?php declare(strict_types=1);
/**
 * This file is part of the daikon-cqrs/bitcoin-interop project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Daikon\Bitcoin\ValueObject;

use Daikon\Interop\Assertion;
use Daikon\Interop\MakeEmptyInterface;
use Daikon\ValueObject\ValueObjectInterface;

final class Hash implements MakeEmptyInterface, ValueObjectInterface
{
    private string $hash;

    public static function sum(string $value): self
    {
        return new self(hash('sha256', $value));
    }

    /** @param null|string $value */
    public static function fromNative($value): self
    {
        Assertion::nullOrRegex($value, '#^$|[a-f0-9]{64}#i', 'Must be 64 hex characters.');
        return empty($value) ? new self : new self($value);
    }

    public static function makeEmpty(): self
    {
        return new self;
    }

    public function isEmpty(): bool
    {
        return empty($this->hash);
    }

    /** @param self $comparator */
    public function equals($comparator): bool
    {
        Assertion::isInstanceOf($comparator, self::class);
        return $this->toNative() === $comparator->toNative();
    }

    public function toBinary(): string
    {
        return hex2bin($this->hash);
    }

    public function toNative(): string
    {
        return $this->hash;
    }

    public function __toString(): string
    {
        return (string)$this->hash;
    }

    private function __construct(string $hash = '')
    {
        $this->hash = $hash;
    }
}
