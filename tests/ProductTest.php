<?php

namespace App\Tests;

use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function testSettingPrice()
    {
        $product = new Product();

        $this->assertSame(0, $product->getPrice())  ;

        $product->setPrice(9);
        $this->assertSame(9, $product->getPrice());
    }

    public function testProductPriceDidNotChange()
    {
        $product = new Product();
        $product->setPrice(16);

        $this->assertGreaterThan(15, $product->getPrice(), 'Product price should not change here!');
    }
}