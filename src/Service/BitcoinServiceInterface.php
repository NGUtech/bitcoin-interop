<?php declare(strict_types=1);
/**
 * This file is part of the ngutech/bitcoin-interop project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NGUtech\Bitcoin\Service;

use Daikon\Money\Service\PaymentServiceInterface;
use NGUtech\Bitcoin\Entity\BitcoinBlock;
use NGUtech\Bitcoin\Entity\BitcoinTransaction;
use NGUtech\Bitcoin\ValueObject\Address;
use NGUtech\Bitcoin\ValueObject\Bitcoin;
use NGUtech\Bitcoin\ValueObject\Hash;

interface BitcoinServiceInterface extends PaymentServiceInterface
{
    public function request(BitcoinTransaction $transaction): BitcoinTransaction;

    public function send(BitcoinTransaction $transaction): BitcoinTransaction;

    public function validateAddress(Address $address): bool;

    public function estimateFee(BitcoinTransaction $transaction): Bitcoin;

    public function getBlock(Hash $hash): BitcoinBlock;

    public function getTransaction(Hash $id): ?BitcoinTransaction;

    public function getConfirmedBalance(Address $address): Bitcoin;
}
