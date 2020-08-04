<?php declare(strict_types=1);
/**
 * This file is part of the daikon-cqrs/money-interop project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

 namespace Daikon\Tests\Bitcoin\ValueObject;

use Daikon\Bitcoin\ValueObject\Bitcoin;
use Daikon\Interop\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class BitcoinTest extends TestCase
{
    public function testFromNative(): void
    {
        $this->assertEquals('100SAT', Bitcoin::fromNative('100SAT')->toNative());
        $this->assertEquals('-100MSAT', Bitcoin::fromNative('-100MSAT')->toNative());

        $this->expectException(InvalidArgumentException::class);
        Bitcoin::fromNative('100');
    }

    public function testToString(): void
    {
        $this->assertEquals('100BTC', (string)Bitcoin::fromNative('100BTC'));
        $this->assertEquals('-100XBT', (string)Bitcoin::fromNative('-100XBT'));
    }

    public function testZero(): void
    {
        $this->assertEquals('0MSAT', Bitcoin::zero()->toNative());
        $this->assertEquals('0SAT', Bitcoin::zero('SAT')->toNative());
        $this->expectException(InvalidArgumentException::class);
        Bitcoin::zero('AB');
    }

    public function testEquals(): void
    {
        $money = Bitcoin::fromNative('0SAT');
        $this->assertTrue($money->equals(Bitcoin::fromNative('0SAT')));
        $this->assertFalse($money->equals(Bitcoin::fromNative('0MSAT')));
        $this->expectException(InvalidArgumentException::class);
        /** @psalm-suppress InvalidArgument */
        $this->assertFalse($money->equals('nan'));
    }

    public function testGetAmount(): void
    {
        $money = Bitcoin::fromNative('0SAT');
        $this->assertSame('0', $money->getAmount());
    }

    public function testGetCurrency(): void
    {
        $money = Bitcoin::fromNative('0SAT');
        $this->assertSame('SAT', $money->getCurrency());
    }

    public function testPercentage(): void
    {
        $money = Bitcoin::fromNative('0SAT');
        $this->assertEquals('0SAT', (string)$money->percentage(0));
        $this->assertSame('0SAT', (string)$money->percentage(10));
        $this->assertSame('0', $money->percentage(10.12345, Bitcoin::ROUND_UP)->getAmount());
        $this->assertEquals('0SAT', (string)$money->percentage(100, Bitcoin::ROUND_DOWN));

        $money = Bitcoin::fromNative('100SAT');
        $this->assertEquals('0SAT', (string)$money->percentage(0));
        $this->assertSame('10SAT', (string)$money->percentage(10));
        $this->assertSame('11', $money->percentage(10.12345, Bitcoin::ROUND_UP)->getAmount());
        $this->assertSame('10', $money->percentage(10.12345, Bitcoin::ROUND_DOWN)->getAmount());
        $this->assertEquals('100SAT', (string)$money->percentage(100, Bitcoin::ROUND_DOWN));
    }
}
