<?php

namespace Ixolit\Dislo\Test\Response;

use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\Test\WorkingObjects\PackageMock;
use Ixolit\Dislo\WorkingObjects\Package;

/**
 * Class TestPackageGetResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestPackageGetResponse implements TestResponseInterface {

    /**
     * @var Package[]
     */
    private $packages;

    /**
     * TestPackageGetResponse constructor.
     */
    public function __construct() {
        $packagesCount = MockHelper::getFaker()->numberBetween(1, 5);

        for ($i = 0; $i < $packagesCount; $i++) {
            $package = PackageMock::create();

            $this->packages[$package->getPackageIdentifier()] = $package;
        }
    }

    /**
     * @return Package[]
     */
    public function getPackages() {
        return $this->packages;
    }

    /**
     * @param string $uri
     * @param array  $data
     *
     * @return array
     */
    public function handleRequest($uri, array $data = []) {
        $packages = [];
        foreach ($this->getPackages() as $package) {
            $packages[] = $package->toArray();
        }

        return [
            'packages' => $packages,
        ];
    }

}