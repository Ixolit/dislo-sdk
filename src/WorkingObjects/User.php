<?php

namespace Ixolit\Dislo\WorkingObjects;

class User implements WorkingObject {
	/**
	 * @var int
	 */
	private $userId;
	/**
	 * @var \DateTime
	 */
	private $createdAt;
	/**
	 * @var bool
	 */
	private $loginDisabled;
	/**
	 * @var string
	 */
	private $language;
	/**
	 * @var \DateTime|null
	 */
	private $lastLoginDate;
	/**
	 * @var string
	 */
	private $lastLoginIp;
	/**
	 * @var array
	 */
	private $metaData;

	/**
	 * @var string|null
	 */
	private $currencyCode;

	/**
	 * @var array
	 */
	private $verifiedData = [];

    /**
     * @var AuthToken
     */
	private $authToken;

    /**
     * @var string|null
     */
	private $metaprofileName;

    /**
     * @param int            $userId
     * @param \DateTime      $createdAt
     * @param bool           $loginDisabled
     * @param string         $language
     * @param \DateTime      $lastLoginDate
     * @param string         $lastLoginIp
     * @param array          $metaData
     * @param string|null    $currencyCode
     * @param string[]       $verifiedData
     * @param AuthToken|null $authToken
     * @param string|null    $metaprofileName
     */
	public function __construct(
        $userId,
        $createdAt,
        $loginDisabled,
        $language,
        $lastLoginDate,
        $lastLoginIp,
        $metaData,
        $currencyCode = null,
        $verifiedData = [],
        AuthToken $authToken = null,
        $metaprofileName = null
    ) {
		$this->userId          = $userId;
		$this->createdAt       = $createdAt;
		$this->loginDisabled   = $loginDisabled;
		$this->language        = $language;
		$this->lastLoginDate   = $lastLoginDate;
		$this->lastLoginIp     = $lastLoginIp;
		$this->metaData        = $metaData;
		$this->currencyCode    = $currencyCode;
		$this->verifiedData    = $verifiedData;
		$this->authToken       = $authToken;
		$this->metaprofileName = $metaprofileName;
	}

	/**
	 * @return int
	 */
	public function getUserId() {
		return $this->userId;
	}

	/**
	 * @return \DateTime
	 */
	public function getCreatedAt() {
		return $this->createdAt;
	}

	/**
	 * @return boolean
	 */
	public function isLoginDisabled() {
		return $this->loginDisabled;
	}

	/**
	 * @return string
	 */
	public function getLanguage() {
		return $this->language;
	}

	/**
	 * @return \DateTime
	 */
	public function getLastLoginDate() {
		return $this->lastLoginDate;
	}

	/**
	 * @return string
	 */
	public function getLastLoginIp() {
		return $this->lastLoginIp;
	}

	/**
	 * @return array
	 */
	public function getMetaData() {
		return $this->metaData;
	}

	/**
	 * @param string $metaDataName
	 *
	 * @return string|null
	 */
	public function getMetaDataEntry($metaDataName) {
		$metaData = $this->getMetaData();

		return isset($metaData[$metaDataName]) ? $metaData[$metaDataName] : null;
	}

	/**
	 * @return null|string
	 */
	public function getCurrencyCode() {
		return $this->currencyCode;
	}

	/**
	 * @return string[]
	 */
	public function getVerifiedData() {
		return $this->verifiedData;
	}

	/**
	 * @return bool
	 */
	public function isEmailVerified() {
		return in_array('email', $this->verifiedData);
	}

    /**
     * @return AuthToken|null
     */
	public function getAuthToken() {
	    return $this->authToken;
    }

    /**
     * @param AuthToken $authToken
     * @return $this
     */
    public function setAuthToken(AuthToken $authToken){
        $this->authToken = $authToken;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMetaprofileName() {
        return $this->metaprofileName;
    }

    /**
     * @param $metaprofileName
     *
     * @return $this
     */
    public function setMetaprofileName($metaprofileName) {
        $this->metaprofileName = $metaprofileName;
        return $this;
    }

	/**
	 * @param array $response
	 *
	 * @return self
	 */
	public static function fromResponse($response) {
		return new User(
			$response['userId'],
            new \DateTime($response['createdAt']),
            $response['loginDisabled'],
            $response['language'],
            ($response['lastLoginDate'] ? new \DateTime($response['lastLoginDate']) : null),
            $response['lastLoginIp'],
            $response['metaData'],
            (isset($response['currencyCode']) ? $response['currencyCode'] : null),
            (isset($response['verifiedData']) ? $response['verifiedData'] : []),
            (isset($response['authToken']) ? AuthToken::fromResponse($response['authToken']) : null),
            (isset($response['metaprofileName']) ? $response['metaprofileName'] : null)
		);
	}

	/**
	 * @return array
	 */
	public function toArray() {
		return [
            '_type'           => 'User',
            'userId'          => $this->userId,
            'createdAt'       => $this->createdAt->format('Y-m-d H:i:s'),
            'loginDisabled'   => $this->loginDisabled,
            'language'        => $this->language,
            'lastLoginDate'   => ($this->lastLoginDate ? $this->lastLoginDate->format('Y-m-d H:i:s') : null),
            'lastLoginIp'     => $this->lastLoginIp,
            'metaData'        => $this->metaData,
            'currencyCode'    => $this->currencyCode,
            'verifiedData'    => $this->verifiedData,
            'authToken'       => ($this->authToken ? $this->authToken->toArray() : null),
            'metaprofileName' => $this->metaprofileName,
		];
	}
}