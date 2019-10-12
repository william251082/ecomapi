<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Taxon;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class TaxonFixtures extends BaseFixtures implements DependentFixtureInterface
{
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(
            50,
            'main_taxons',
            function () use($manager) {
                $taxon = new Taxon();
                $taxon->setTitle($this->faker->title);
                $taxon->setPublishedAt($this->faker->dateTimeBetween('-1 months', '-1 seconds'));
                $taxon->setContent(
                    $this->faker->boolean ? $this->faker->paragraph : $this->faker->sentences(2, true)
                );
                $taxon->setSlug($this->faker->slug);
                $this->setDateTimes($taxon);

                $taxon->setAuthor($this->getRandomReference('admin_users'));

                return $taxon;
            }
        );

        $this->createMany(
            50,
            'normal_taxons',
            function () use($manager) {
                $taxon = new Taxon();
                $taxon->setTitle($this->faker->title);
                $taxon->setPublishedAt($this->faker->dateTimeBetween('-1 months', '-1 seconds'));
                $taxon->setContent(
                    $this->faker->boolean ? $this->faker->paragraph : $this->faker->sentences(2, true)
                );
                $taxon->setSlug($this->faker->slug);
                $this->setDateTimes($taxon);

                $taxon->setAuthor($this->getRandomReference('anonymous_users'));

                return $taxon;
            }
        );

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            // ordering important
            UserFixtures::class
        ];
    }
}