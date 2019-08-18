<?php

namespace App\Tests;
use PHPUnit\Framework\TestCase;

class SimpleTest extends TestCase
{
    public function testAddition()
    {
        $value = true;
        $array = ['key' => 'value'];

        $this->assertEquals(5, 2 + 3, 'They are equal.');
        $this->assertTrue($value);
        $this->assertArrayHasKey('key', $array);
        $this->assertEquals('value', $array['key']);
        $this->assertCount(1, $array);
    }
}