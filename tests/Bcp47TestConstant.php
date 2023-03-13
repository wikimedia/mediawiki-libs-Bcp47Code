<?php

namespace Wikimedia\Bcp47Code\Tests;

use Wikimedia\Bcp47Code\Bcp47Code;

class Bcp47TestConstant implements Bcp47Code {
	/** @inheritDoc */
	public function toBcp47Code(): string {
		# Valid but bogus BCP 47 code, for test purposes
		return 'en-x-testvariant';
	}

	/** @inheritDoc */
	public function isSameCodeAs( Bcp47Code $other ): bool {
		return strcasecmp( $this->toBcp47Code(), $other->toBcp47Code() ) === 0;
	}
}
