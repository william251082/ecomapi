<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private $faker;

    private const USERS = [
        [
            'username' => 'admin',
            'email' => 'admin@blog.com',
            'password' => 'secret123#',
            'roles' => [User::ROLE_SUPER_ADMIN]
        ],
        [
            'username' => 'john_doe',
            'email' => 'john@blog.com',
            'password' => 'secret123#',
            'roles' => [User::ROLE_ADMIN]
        ],
        [
            'username' => 'rob_smith',
            'email' => 'rob@blog.com',
            'password' => 'secret123#',
            'roles' => [User::ROLE_CUSTOMER]
        ],
        [
            'username' => 'jenny_rowling',
            'email' => 'jenny@blog.com',
            'password' => 'secret123#',
            'roles' => [User::ROLE_VISITOR]
        ],
        [
            'username' => 'han_solo',
            'email' => 'han@blog.com',
            'password' => 'secret123#',
            'roles' => [User::ROLE_CUSTOMER]
        ],
        [
            'username' => 'jedi_knight',
            'email' => 'jedi@blog.com',
            'password' => 'secret123#',
            'roles' => [User::ROLE_VISITOR]
        ],
    ];

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
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

            $ownerReference = $this->getRandomOwnerReference($product);
            $product->setOwner($ownerReference);


            $manager->persist($product);
        }
    }

    private function loadUsers(ObjectManager $manager)
    {
        foreach (self::USERS as $userFixture) {
            $user = new User();
            $user->setUsername($userFixture['username']);
            $user->setEmail($userFixture['email']);
            $user->setPassword($this->faker->password);
            $user->setRoles($userFixture['roles']);

            $this->addReference('user_'.$userFixture['username'], $user);

            $manager->persist($user);
        }
    }

    private function getRandomOwnerReference($entity): User
    {
        $randomOwner = self::USERS[rand(0,5)];
        if ($entity instanceof Product && array_intersect(
                $randomOwner['roles'],
                [User::ROLE_SUPER_ADMIN, User::ROLE_ADMIN, User::ROLE_CUSTOMER]
            )) {
            return $this->getRandomOwnerReference($entity);
        }

        return $this->getReference('user_'.$randomOwner['username']);
    }
}
