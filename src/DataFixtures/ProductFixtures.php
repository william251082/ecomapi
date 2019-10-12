<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ProductFixtures extends BaseFixtures implements DependentFixtureInterface
{
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(100, 'products', function () {
            $product = new Product();
            $product->setName($this->faker->name);
            $product->setDescription(
                $this->faker->boolean ? $this->faker->paragraph : $this->faker->sentences(2, true)
            );
            $product->setPrice($this->faker->randomNumber(2));
            $product->setIsPublished($this->faker->boolean(60));
            $this->setDateTimes($product);

            $product->setOwner($this->getRandomReference('admin_users'));
            $product->setTaxon($this->getRandomReference('main_taxons'));

            return $product;
        });

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            // ordering important
            TaxonFixtures::class
        ];
    }
}