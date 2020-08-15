<?php declare(strict_types=1);
/**
 * This file is part of the ngutech/bitcoin-interop project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NGUtech\Bitcoin\Message;

use Daikon\Interop\Assertion;
use Daikon\ValueObject\Timestamp;
use NGUtech\Bitcoin\ValueObject\Hash;

final class BitcoinTransactionHashReceived implements BitcoinMessageInterface
{
    private Hash $hash;

    private Timestamp $receivedAt;

    /** @param array $state */
    public static function fromNative($state): self
    {
        Assertion::isArray($state);
        Assertion::keyExists($state, 'hash');
        Assertion::keyExists($state, 'receivedAt');

        return new self(
            Hash::fromNative($state['hash']),
            Timestamp::fromNative($state['receivedAt'])
        );
    }

    public function toNative(): array
    {
        return [
            'hash' => (string)$this->hash,
            'receivedAt' => (string)$this->receivedAt
        ];
    }

    public function getHash(): Hash
    {
        return $this->hash;
    }

    public function getReceivedAt(): Timestamp
    {
        return $this->receivedAt;
    }

    public function __toString(): string
    {
        return (string)$this->hash;
    }

    private function __construct(Hash $hash, Timestamp $receivedAt)
    {
        $this->hash = $hash;
        $this->receivedAt = $receivedAt;
    }
}
