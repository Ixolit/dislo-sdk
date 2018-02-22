<?php

namespace Ixolit\Dislo\WorkingObjects\Billing;


use Ixolit\Dislo\WorkingObjects\AbstractWorkingObject;
use Ixolit\Dislo\WorkingObjectsCustom\Billing\FlexibleObjectCustom;

/**
 * Class FlexibleObject
 *
 * @package Ixolit\Dislo\WorkingObjects
 */
final class FlexibleObject extends AbstractWorkingObject {

    const STATUS_ACTIVE = 'active';
    const STATUS_CLOSED = 'closed';
    const STATUS_PENDING = 'pending';

    /**
     * @var int
     */
    private $flexibleId;
    /**
     * @var string
     */
    private $status;

    /**
     * @var string[]
     */
    private $metaData = [];

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var string
     */
    private $billingMethod;

    /**
     * @var BillingMethodObject
     */
    private $billingMethodObject;

    /**
     * @param int                      $flexibleId
     * @param string                   $status
     * @param string[]                 $metaData
     * @param \DateTime                $createdAt
     * @param string                   $billingMethod
     * @param BillingMethodObject|null $billingMethodObject
     */
    public function __construct(
        $flexibleId,
        $status,
        $metaData,
        \DateTime $createdAt,
        $billingMethod,
        BillingMethodObject $billingMethodObject = null
    ) {
        $this->flexibleId    = $flexibleId;
        $this->status        = $status;
        $this->metaData      = $metaData;
        $this->createdAt     = $createdAt;
        $this->billingMethod = $billingMethod;
        $this->billingMethodObject = $billingMethodObject;
        $this->addCustomObject();
    }

    /**
     * @return FlexibleObjectCustom|null
     */
    public function getCustom() {
        /** @var FlexibleObjectCustom $custom */
        $custom = ($this->getCustomObject() instanceof FlexibleObjectCustom) ? $this->getCustomObject() : null;
        return $custom;
    }

    /**
     * @return int
     */
    public function getFlexibleId() {
        return $this->flexibleId;
    }

    /**
     * @return string
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * @return \string[]
     */
    public function getMetaData() {
        return $this->metaData;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getBillingMethod() {
        return $this->billingMethod;
    }

    /**
     * @return BillingMethodObject|null
     */
    public function getBillingMethodObject() {
        return $this->billingMethodObject;
    }

    /**
     * @param array $response
     *
     * @return FlexibleObject
     */
    public static function fromResponse($response) {
        return new self(
            static::getValueIsSet($response, 'flexibleId'),
            static::getValueIsSet($response, 'status'),
            static::getValueIsSet($response, 'metaData'),
            static::getValueAsDateTime($response, 'createdAt'),
            static::getValueIsSet($response, 'billingMethod'),
            static::getValueIsSet($response, 'billingMethodObject', null, function ($value) {
                return BillingMethodObject::fromResponse($value);
            })
        );
    }

    /**
     * @return array
     */
    public function toArray() {
        return [
            '_type'               => 'Flexible',
            'flexibleId'          => $this->flexibleId,
            'status'              => $this->status,
            'metaData'            => $this->metaData,
            'createdAt'           => $this->createdAt->format('Y-m-d H:i:s'),
            'billingMethod'       => $this->billingMethod,
            'billingMethodObject' => $this->billingMethodObject->toArray(),
        ];
    }

}