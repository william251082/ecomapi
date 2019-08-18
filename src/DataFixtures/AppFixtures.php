<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        $this->loadProducts($manager);

        $manager->flush();
    }

    private function loadProducts(ObjectManager $manager)
    {
        for ($i = 0; $i < 50; $i++) {
            $product = new Product();
            $product->setName($this->faker->realText(15));
            $product->setDescription($this->faker->realText(100));
            $product->setPrice($this->faker->randomFloat(2));
            $product->setCreatedAt($this->faker->dateTimeThisYear());
            $product->setIsPublished($this->faker->boolean);

            $manager->persist($product);
        }
    }
}
