<?php
namespace test;

use Ixolit\Dislo\Redirector\Rules\Conditions\CountryCheck;

/**
 * Class CountryCheckTest
 * @package Ixolit\Dislo\Redirector
 */
class CountryCheckTest extends \PHPUnit_Framework_TestCase
{

    public function testCountryCheck1() {

        // test data
        $country = 'AT';
        $comparator = 'equals';
        $requestCountry = 'AT';
        $expectedResult = true;

        // build objects
        $countryCheck = new CountryCheck(['country' => $country, 'comparator' => $comparator]);

        // test
        $result = $countryCheck->check($requestCountry);
        $this->assertEquals($expectedResult, $result);
    }

    public function testCountryCheck2() {

        // test data
        $country = 'AT';
        $comparator = 'equals';
        $requestCountry = 'DE';
        $expectedResult = false;

        // build objects
        $countryCheck = new CountryCheck(['country' => $country, 'comparator' => $comparator]);

        // test
        $result = $countryCheck->check($requestCountry);
        $this->assertEquals($expectedResult, $result);
    }

    public function testCountryCheck3() {

        // test data
        $country = 'AT';
        $comparator = 'not_equals';
        $requestCountry = 'AT';
        $expectedResult = false;

        // build objects
        $countryCheck = new CountryCheck(['country' => $country, 'comparator' => $comparator]);

        // test
        $result = $countryCheck->check($requestCountry);
        $this->assertEquals($expectedResult, $result);
    }

    public function testCountryCheck4() {

        // test data
        $country = 'AT';
        $comparator = 'not_equals';
        $requestCountry = 'DE';
        $expectedResult = true;

        // build objects
        $countryCheck = new CountryCheck(['country' => $country, 'comparator' => $comparator]);

        // test
        $result = $countryCheck->check($requestCountry);
        $this->assertEquals($expectedResult, $result);
    }


}