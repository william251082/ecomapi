<?php

declare(strict_types=1);

namespace App\Tests;

use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    private $product;

    protected function setUp()
    {
        $this->product = new Product();
    }

    public function testSettingPrice()
    {
        $this->assertSame(0, $this->product->getPrice())  ;

        $this->product->setPrice(9);
        $this->assertSame(9, $this->product->getPrice());
    }

    public function testProductPriceDidNotChange()
    {
        $this->product->setPrice(16);

        $this->assertGreaterThan(
            15, $this->product->getPrice(), 'Product price should not change here!'
        );
    }

    public function testReturnFullDescriptionForProduct()
    {
        $this->markTestSkipped('Description is can not be null');

        // TODO get the expected description from the test db
        $this->assertSame(
            null,
            $this->product->getDescription()
        );
    }

    protected function tearDown()
    {
        $this->product = null;
    }
}