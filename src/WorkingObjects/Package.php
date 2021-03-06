<?php

namespace Ixolit\Dislo\WorkingObjects;

use Ixolit\Dislo\Exceptions\ObjectNotFoundException;

class Package implements WorkingObject {
	/**
	 * @var string
	 */
	private $packageIdentifier;
	/**
	 * @var string
	 */
	private $serviceIdentifier;
	/**
	 * @var DisplayName[]
	 */
	private $displayNames;
	/**
	 * @var bool
	 */
	private $signupAvailable;
	/**
	 * @var Package[]
	 */
	private $addonPackages;
	/**
	 * @var string[]
	 */
	private $metaData;
	/**
	 * @var PackagePeriod
	 */
	private $initialPeriod;
	/**
	 * @var PackagePeriod|null
	 */
	private $recurringPeriod;

	/** @var bool */
	private $hasTrialPeriod;

	/** @var BillingMethod[] */
	private $billingMethods = [];

	/** @var bool */
	private $requireFlexibleForFreeSignup;

    /**
     * @param string             $packageIdentifier
     * @param string             $serviceIdentifier
     * @param DisplayName[]      $displayNames
     * @param bool               $signupAvailable
     * @param Package[]          $addonPackages
     * @param string[]           $metaData
     * @param PackagePeriod|null $initialPeriod
     * @param PackagePeriod|null $recurringPeriod
     * @param bool               $hasTrialPeriod
     * @param BillingMethod[]    $billingMethods
     * @param bool               $requireFlexibleForFreeSignup
     */
	public function __construct($packageIdentifier,
                                $serviceIdentifier,
                                $displayNames,
                                $signupAvailable,
								$addonPackages,
                                $metaData,
                                $initialPeriod,
                                $recurringPeriod,
                                $hasTrialPeriod = false,
								$billingMethods = null,
                                $requireFlexibleForFreeSignup = false
    ) {
        $this->packageIdentifier            = $packageIdentifier;
        $this->serviceIdentifier            = $serviceIdentifier;
        $this->displayNames                 = $displayNames;
        $this->signupAvailable              = $signupAvailable;
        $this->addonPackages                = $addonPackages;
        $this->metaData                     = $metaData;
        $this->initialPeriod                = $initialPeriod;
        $this->recurringPeriod              = $recurringPeriod;
        $this->hasTrialPeriod               = $hasTrialPeriod;
        $this->billingMethods               = $billingMethods;
        $this->requireFlexibleForFreeSignup = $requireFlexibleForFreeSignup;
	}

	/**
	 * @return string
	 */
	public function getPackageIdentifier() {
		return $this->packageIdentifier;
	}

	/**
	 * @return string
	 */
	public function getServiceIdentifier() {
		return $this->serviceIdentifier;
	}

	/**
	 * @return DisplayName[]
	 */
	public function getDisplayNames() {
		return $this->displayNames;
	}

	/**
	 * @param string $languageCode
	 * @return DisplayName
	 *
	 * @throws ObjectNotFoundException
	 */
	public function getDisplayNameForLanguage($languageCode) {
		foreach ($this->displayNames as $displayName) {
			if ($displayName->getLanguage() == $languageCode) {
				return $displayName;
			}
		}
		throw new ObjectNotFoundException('No display name for language ' . $languageCode . ' on package ' .
			$this->packageIdentifier);
	}

	/**
	 * @return boolean
	 */
	public function isSignupAvailable() {
		return $this->signupAvailable;
	}

	/**
	 * @return Package[]
	 */
	public function getAddonPackages() {
		return $this->addonPackages;
	}

	/**
	 * @return string[]
	 */
	public function getMetaData() {
		return $this->metaData;
	}

	/**
	 * @param string $metaDataName
	 *
	 * @return null|string
	 */
	public function getMetaDataEntry($metaDataName) {
		$metaData = $this->getMetaData();

		return isset($metaData[$metaDataName]) ? $metaData[$metaDataName] : null;
	}

	/**
	 * @return PackagePeriod|null
	 */
	public function getInitialPeriod() {
		return $this->initialPeriod;
	}

	/**
	 * @return PackagePeriod|null
	 */
	public function getRecurringPeriod() {
		return $this->recurringPeriod;
	}

	/**
	 * @return bool
	 */
	public function hasTrialPeriod() {
		return $this->hasTrialPeriod;
	}

	/**
	 * @return BillingMethod[]
	 */
	public function getBillingMethods() {
		return $this->billingMethods;
	}

    /**
     * @return bool
     */
	public function requiresFlexibleForFreeSignup() {
	    return $this->requireFlexibleForFreeSignup;
    }

	/**
	 * @param array $response
	 *
	 * @return self
	 */
	public static function fromResponse($response) {
		$displayNames = [];
		foreach ($response['displayNames'] as $displayName) {
			$displayNames[] = DisplayName::fromResponse($displayName);
		}
		$addonPackages = [];
		if(isset($response['addonPackages'])) {
			foreach ($response['addonPackages'] as $addonPackage) {
				$addonPackages[] = Package::fromResponse($addonPackage);
			}
		}

		$billingMethods = [];
		if(isset($response['billingMethods'])) {
			foreach ($response['billingMethods'] as $billingMethod) {
				$billingMethods[] = BillingMethod::fromResponse($billingMethod);
			}
		}

		return new Package(
			$response['packageIdentifier'],
			$response['serviceIdentifier'],
			$displayNames,
			$response['signupAvailable'],
			$addonPackages,
			isset($response['metaData']) ? $response['metaData'] : array(),
			isset($response['initialPeriod']) && $response['initialPeriod'] ? PackagePeriod::fromResponse($response['initialPeriod']) : null,
			isset($response['recurringPeriod']) && $response['recurringPeriod'] ? PackagePeriod::fromResponse($response['recurringPeriod']) : null,
			isset($response['hasTrialPeriod']) ? $response['hasTrialPeriod'] : false,
			$billingMethods,
            isset($response['requireFlexibleForFreeSignup'])
                ? $response['requireFlexibleForFreeSignup']
                : false
		);
	}

	/**
	 * @return array
	 */
	public function toArray() {
		$displayNames = [];
		foreach ($this->displayNames as $displayName) {
			$displayNames[] = $displayName->toArray();
		}

		$addonPackages = [];
		foreach ($this->addonPackages as $package) {
			$addonPackages[] = $package->toArray();
		}

		$billingMethods = [];
		foreach ($this->billingMethods as $billingMethod) {
			$billingMethods[] = $billingMethod->toArray();
		}

		return [
            '_type'                        => 'Package',
            'packageIdentifier'            => $this->packageIdentifier,
            'serviceIdentifier'            => $this->serviceIdentifier,
            'displayNames'                 => $displayNames,
            'signupAvailable'              => $this->signupAvailable,
            'addonPackages'                => $addonPackages,
            'metaData'                     => $this->metaData,
            'initialPeriod'                => $this->initialPeriod ? $this->initialPeriod->toArray() : null,
            'recurringPeriod'              => ($this->recurringPeriod ? $this->recurringPeriod->toArray() : null),
            'hasTrialPeriod'               => $this->hasTrialPeriod,
            'billingMethods'               => $billingMethods,
            'requireFlexibleForFreeSignup' => $this->requireFlexibleForFreeSignup,
        ];
	}
}