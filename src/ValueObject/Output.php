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
use Daikon\ValueObject\ValueObjectInterface;

final class Output implements ValueObjectInterface
{
    private Address $address;

    private Bitcoin $value;

    /** @param array $state */
    public static function fromNative($state): self
    {
        Assert::that($state)
            ->isArray('Must be an array.')
            ->notEmpty('Must not be empty.')
            ->keyExists('address', "Missing key 'address'.")
            ->keyExists('value', "Missing key 'value'.");

        return new self(Address::fromNative($state['address']), Bitcoin::fromNative($state['value']));
    }

    public function toNative(): array
    {
        return [
            'address' => (string)$this->address,
            'value' => (string)$this->value
        ];
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function getValue(): Bitcoin
    {
        return $this->value;
    }

    /** @param self $comparator */
    public function equals($comparator): bool
    {
        Assertion::isInstanceOf($comparator, self::class);
        return $this->toNative() === $comparator->toNative();
    }

    public function __toString(): string
    {
        return (string)$this->address.':'.(string)$this->value;
    }

    private function __construct(Address $address, Bitcoin $value)
    {
        $this->address = $address;
        $this->value = $value;
    }
}
