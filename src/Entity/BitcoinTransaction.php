<?php declare(strict_types=1);
/**
 * This file is part of the daikon-cqrs/bitcoin-interop project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Daikon\Bitcoin\Entity;

use Daikon\Bitcoin\ValueObject\Address;
use Daikon\Bitcoin\ValueObject\Bitcoin;
use Daikon\Bitcoin\ValueObject\Hash;
use Daikon\Entity\Attribute;
use Daikon\Entity\AttributeMap;
use Daikon\Entity\EntityTrait;
use Daikon\Money\Entity\TransactionInterface;
use Daikon\ValueObject\BoolValue;
use Daikon\ValueObject\IntValue;
use Daikon\ValueObject\Text;

final class BitcoinTransaction implements TransactionInterface
{
    use EntityTrait;

    public static function getAttributeMap(): AttributeMap
    {
        return new AttributeMap([
            Attribute::define('id', Hash::class),
            Attribute::define('address', Address::class),
            Attribute::define('label', Text::class),
            Attribute::define('amount', Bitcoin::class),
            Attribute::define('fee', Bitcoin::class),
            Attribute::define('comment', Text::class),
            Attribute::define('confTarget', IntValue::class),
            Attribute::define('confirmations', IntValue::class),
            Attribute::define('rbf', BoolValue::class),
        ]);
    }

    public function getIdentity(): Hash
    {
        return $this->getId();
    }

    public function getId(): Hash
    {
        return $this->get('id') ?? Hash::makeEmpty();
    }

    public function getAddress(): Address
    {
        return $this->get('address') ?? Address::makeEmpty();
    }

    public function getLabel(): Text
    {
        return $this->get('label') ?? Text::makeEmpty();
    }

    public function getAmount(): Bitcoin
    {
        return $this->get('amount') ?? Bitcoin::zero();
    }

    public function getFee(): Bitcoin
    {
        return $this->get('fee') ?? Bitcoin::zero();
    }

    public function getComment(): Text
    {
        return $this->get('comment') ?? Text::makeEmpty();
    }

    public function getConfTarget(): IntValue
    {
        return $this->get('confTarget') ?? IntValue::fromNative(3);
    }

    public function getConfirmations(): IntValue
    {
        return $this->get('confirmations') ?? IntValue::zero();
    }

    public function getRbf(): BoolValue
    {
        return $this->get('rbf') ?? BoolValue::false();
    }
}
