<?php

namespace Wikimedia\Bcp47Code\Tests;

use Wikimedia\Bcp47Code\Bcp47Code;
use Wikimedia\Bcp47Code\Bcp47CodeValue;

/**
 * @coversDefaultClass \Wikimedia\Bcp47Code\Bcp47CodeValue
 */
class Bcp47CodeValueTest extends \PHPUnit\Framework\TestCase {

	/**
	 * @covers ::toBcp47Code
	 */
	public function testToBcp47Code() {
		$en = new Bcp47CodeValue( 'en' );
		# Note that BCP 47 codes are technically case-insensitive.
		$this->assertEqualsIgnoringCase( 'en', $en->toBcp47Code() );

		# create a new Bcp47CodeValue from a Bcp47CodeValue
		$en2 = Bcp47CodeValue::fromBcp47Code( $en );
		$this->assertEqualsIgnoringCase( 'en', $en2->toBcp47Code() );
	}

	/**
	 * @covers ::fromBcp47Code
	 */
	public function testFromBcp47Code() {
		# create a new Bcp47CodeValue from an anonymous implementation of
		# Bcp47Code
		$es = Bcp47CodeValue::fromBcp47Code( new class implements Bcp47Code {
			/** @inheritDoc */
			public function toBcp47Code(): string {
				return 'es';
			}

			/** @inheritDoc */
			public function isSameCodeAs( Bcp47Code $other ): bool {
				return Bcp47CodeValue::isSameCode( $this, $other );
			}
		} );
		$this->assertEqualsIgnoringCase( 'es', $es->toBcp47Code() );

		# create a new Bcp47CodeValue from Bcp47TestConstant
		$test = Bcp47CodeValue::fromBcp47Code( new Bcp47TestConstant );
		$this->assertEqualsIgnoringCase( 'en-x-testvariant', $test->toBcp47Code() );
	}

	/**
	 * @covers ::isSameCodeAs
	 */
	public function testIsSameCodeAs() {
		$esLower = new Bcp47CodeValue( 'es' );
		$enLower = new Bcp47CodeValue( 'en' );
		$esUpper = new Bcp47CodeValue( 'ES' );
		$this->assertSame( true, $esLower->isSameCodeAs( $esUpper ) );
		$this->assertSame( true, $esUpper->isSameCodeAs( $esLower ) );
		$this->assertSame( false, $esLower->isSameCodeAs( $enLower ) );
	}
}
