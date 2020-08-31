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
use Daikon\Money\Entity\TransactionInterface;
use Daikon\ValueObject\BoolValue;
use Daikon\ValueObject\FloatValue;
use Daikon\ValueObject\IntValue;
use Daikon\ValueObject\Text;
use NGUtech\Bitcoin\ValueObject\Bitcoin;
use NGUtech\Bitcoin\ValueObject\Hash;
use NGUtech\Bitcoin\ValueObject\OutputList;

final class BitcoinTransaction extends Entity implements TransactionInterface
{
    public static function getAttributeMap(): AttributeMap
    {
        return new AttributeMap([
            Attribute::define('id', Hash::class),
            Attribute::define('label', Text::class),
            Attribute::define('amount', Bitcoin::class),
            Attribute::define('outputs', OutputList::class),
            Attribute::define('feeRate', FloatValue::class),
            Attribute::define('feeEstimate', Bitcoin::class),
            Attribute::define('feeSettled', Bitcoin::class),
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

    public function getLabel(): Text
    {
        return $this->get('label') ?? Text::makeEmpty();
    }

    public function getAmount(): Bitcoin
    {
        return $this->get('amount') ?? Bitcoin::makeEmpty();
    }

    public function getOutputs(): OutputList
    {
        return $this->get('outputs') ?? OutputList::makeEmpty();
    }

    public function getFeeRate(): FloatValue
    {
        return $this->get('feeRate') ?? FloatValue::makeEmpty();
    }

    public function getFeeEstimate(): Bitcoin
    {
        return $this->get('feeEstimate') ?? Bitcoin::makeEmpty();
    }

    public function getFeeSettled(): Bitcoin
    {
        return $this->get('feeSettled') ?? Bitcoin::makeEmpty();
    }

    public function getFeeRefund(): Bitcoin
    {
        return $this->getFeeEstimate()->subtract($this->getFeeSettled());
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
