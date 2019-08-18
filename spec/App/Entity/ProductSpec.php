<?php

namespace spec\App\Entity;

use App\Entity\Product;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ProductSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Product::class);
    }

    function it_should_allow_to_set_name()
    {
        $this->setName('coffee');

        $this->getName()->shouldReturn('coffee');
    }

    function it_should_return_description()
    {
        $this->setDescription('Product description');

        $this->getDescription()->shouldReturn('Product description');
    }

    function it_should_be_constructed_with_createdAt()
    {
        $this->beConstructedWith(new \DateTimeImmutable(), true);
    }
}
