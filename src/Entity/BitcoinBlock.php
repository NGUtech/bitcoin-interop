<?php declare(strict_types=1);
/**
 * This file is part of the ngutech/bitcoin-interop project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NGUtech\Bitcoin\Entity;

use Daikon\Entity\Attribute;
use Daikon\Entity\AttributeMap;
use Daikon\Entity\Entity;
use Daikon\ValueObject\IntValue;
use Daikon\ValueObject\Timestamp;
use NGUtech\Bitcoin\ValueObject\Hash;
use NGUtech\Bitcoin\ValueObject\HashList;

final class BitcoinBlock extends Entity
{
    public static function getAttributeMap(): AttributeMap
    {
        return new AttributeMap([
            Attribute::define('hash', Hash::class),
            Attribute::define('merkleRoot', Hash::class),
            Attribute::define('confirmations', IntValue::class),
            Attribute::define('transactions', HashList::class),
            Attribute::define('height', IntValue::class),
            Attribute::define('timestamp', Timestamp::class)
        ]);
    }

    public function getIdentity(): Hash
    {
        return $this->getHash();
    }

    public function getHash(): Hash
    {
        return $this->get('hash') ?? Hash::makeEmpty();
    }

    public function getMerkleRoot(): Hash
    {
        return $this->get('merkleRoot') ?? Hash::makeEmpty();
    }

    public function getConfirmations(): IntValue
    {
        return $this->get('confirmations') ?? IntValue::zero();
    }

    public function getTransactions(): HashList
    {
        return $this->get('transactions') ?? HashList::makeEmpty();
    }

    public function getHeight(): IntValue
    {
        return $this->get('height') ?? IntValue::zero();
    }

    public function getTimestamp(): Timestamp
    {
        return $this->get('timestamp') ?? Timestamp::makeEmpty();
    }
}
