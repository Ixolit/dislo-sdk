<?php

namespace Ixolit\Dislo\Test\Response;


use Ixolit\Dislo\Test\WorkingObjects\FlexibleMock;
use Ixolit\Dislo\WorkingObjects\Billing\FlexibleObject;

/**
 * Class TestBillingGetFlexibleByIdentifierResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestBillingGetFlexibleByIdentifierResponse implements TestResponseInterface {

    /**
     * @var FlexibleObject
     */
    private $flexible;

    /**
     * TestBillingGetFlexibleByIdentifierResponse constructor.
     */
    public function __construct() {
        $this->flexible = FlexibleMock::create();
    }

    /**
     * @return FlexibleObject
     */
    public function getFlexible() {
        return $this->flexible;
    }

    /**
     * @param string $uri
     * @param array  $data
     *
     * @return array
     */
    public function handleRequest($uri, array $data = []) {
        return [
            'flexible' => $this->getFlexible()->toArray(),
        ];
    }
}