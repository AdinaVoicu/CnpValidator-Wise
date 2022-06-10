<?php

declare(strict_types=1);


use Library\CNP;
use PHPUnit\Framework\TestCase;

final class CNPTest extends TestCase
{
	public function testValidCNP(): void
	{
		$cnp = new CNP('2890905230065');
		$this->assertTrue($cnp->getIsValid());
		$cnp = new CNP('5040708341469');
		$this->assertTrue($cnp->getIsValid());
		$cnp = new CNP('2940413149782');
		$this->assertTrue($cnp->getIsValid());
		$cnp = new CNP('4890720189964');
		$this->assertTrue($cnp->getIsValid());
		$cnp = new CNP('2991209069657');
		$this->assertTrue($cnp->getIsValid());
		$cnp = new CNP('3890610446567');
		$this->assertTrue($cnp->getIsValid());
		$cnp = new CNP('4890720189964');
		$this->assertTrue($cnp->getIsValid());
		$cnp = new CNP('2940413149782');
		$this->assertTrue($cnp->getIsValid());
	}

	public function testInvalidCNP(): void
	{
		$cnp = new CNP('2890905240065');
		$this->assertFalse($cnp->getIsValid());
		$cnp = new CNP('null');
		$this->assertFalse($cnp->getIsValid());
		$cnp = new CNP('0');
		$this->assertFalse($cnp->getIsValid());
		$cnp = new CNP('test');
		$this->assertFalse($cnp->getIsValid());
		$cnp = new CNP('6891600443567');
		$this->assertFalse($cnp->getIsValid());
		$cnp = new CNP('1930101021161');
		$this->assertFalse($cnp->getIsValid());
		$cnp = new CNP('5030945427946');
		$this->assertFalse($cnp->getIsValid());
	}
}
