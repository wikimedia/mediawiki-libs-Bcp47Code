<?php

namespace Wikimedia\Bcp47Code\Tests;

class Bcp47CodeValueTest {

	/**
	 * @covers Bcp47CodeValue::toBcp47Code
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
	 * @covers Bcp47CodeValue::fromBcp47Code
	 */
	public function testFromBcp47Code() {
		# create a new Bcp47CodeValue from an anonymous implementation of
		# Bcp47Code
		$es = Bcp47CodeValue::fromBcp47Code( new class implements Bcp47Code {
			public function toBcp47Code(): string {
				return 'es';
			}
		} );
		$this->assertEqualsIgnoringCase( 'es', $es->toBcp47Code() );

		# create a new Bcp47CodeValue from Bcp47TestConstant
		$test = Bcp47CodeValue::fromBcp47Code( new Bcp47TestConstant );
		$this->assertEqualsIgnoringCase( 'en-x-testvariant', $test->toBcp47Code() );
	}

}
