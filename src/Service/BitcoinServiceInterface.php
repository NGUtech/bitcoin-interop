<?php declare(strict_types=1);
/**
 * This file is part of the daikon-cqrs/bitcoin-interop project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Daikon\Bitcoin\Service;

use Daikon\Bitcoin\Entity\BitcoinBlock;
use Daikon\Bitcoin\Entity\BitcoinTransaction;
use Daikon\Bitcoin\ValueObject\Address;
use Daikon\Bitcoin\ValueObject\Bitcoin;
use Daikon\Bitcoin\ValueObject\Hash;
use Daikon\Money\Service\PaymentServiceInterface;

interface BitcoinServiceInterface extends PaymentServiceInterface
{
    public function request(BitcoinTransaction $transaction): BitcoinTransaction;

    public function send(BitcoinTransaction $transaction): BitcoinTransaction;

    public function calculateFee(BitcoinTransaction $transaction): Bitcoin;

    public function getBlock(Hash $hash): BitcoinBlock;

    public function getTransaction(Hash $id): BitcoinTransaction;

    public function getConfirmedBalance(Address $address): Bitcoin;
}
