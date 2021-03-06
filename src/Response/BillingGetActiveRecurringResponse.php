<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\Recurring;

class BillingGetActiveRecurringResponse {
	/**
	 * @var Recurring
	 */
	private $recurring;

	/**
	 * @param Recurring $recurring
	 */
	public function __construct(Recurring $recurring) {
		$this->recurring = $recurring;
	}

	/**
	 * @return Recurring
	 */
	public function getRecurring() {
		return $this->recurring;
	}

	/**
	 * @param array $response
	 *
	 * @return BillingGetActiveRecurringResponse
	 */
	public static function fromResponse($response) {
		return new BillingGetActiveRecurringResponse(Recurring::fromResponse($response['recurring']));
	}
}