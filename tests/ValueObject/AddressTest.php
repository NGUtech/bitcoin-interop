<?php declare(strict_types=1);
/**
 * This file is part of the ngutech/bitcoin-interop project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NGUtech\Tests\Bitcoin\ValueObject;

use NGUtech\Bitcoin\ValueObject\Address;
use PHPUnit\Framework\TestCase;

final class AddressTest extends TestCase
{
    private const FIXED_REGTEST_ADDRESS = 'mwF1rmTrDH2pJNyRdQrWbWGv5UHeq5xUVq';

    private Address $regtestAddress;

    public function testToNative(): void
    {
        $this->assertEquals(self::FIXED_REGTEST_ADDRESS, $this->regtestAddress->toNative());
        $this->assertEquals('', Address::makeEmpty()->toNative());
        $this->assertEquals('', Address::fromNative(null)->toNative());
    }

    public function testEquals(): void
    {
        $sameAddress = Address::fromNative(self::FIXED_REGTEST_ADDRESS);
        $this->assertTrue($this->regtestAddress->equals($sameAddress));
        $differentAddress = Address::fromNative('xyz');
        $this->assertFalse($this->regtestAddress->equals($differentAddress));
    }

    public function testIsEmpty(): void
    {
        $this->assertTrue(Address::makeEmpty()->isEmpty());
        $this->assertTrue(Address::fromNative('')->isEmpty());
        $this->assertTrue(Address::fromNative(null)->isEmpty());
        $this->assertFalse(Address::fromNative('0')->isEmpty());
        $this->assertFalse($this->regtestAddress->isEmpty());
    }

    public function testToString(): void
    {
        $this->assertEquals(self::FIXED_REGTEST_ADDRESS, (string)$this->regtestAddress);
    }

    public function testMakeEmpty(): void
    {
        $this->assertEquals('', Address::makeEmpty()->toNative());
        $this->assertEquals('', (string)Address::makeEmpty());
        $this->assertTrue(Address::makeEmpty()->isEmpty());
    }

    protected function setUp(): void
    {
        $this->regtestAddress = Address::fromNative(self::FIXED_REGTEST_ADDRESS);
    }
}
