<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends BaseFixtures
{
    private $userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(25, 'admin_users', function() use($manager) {
            $user = new User();
            $user->setEmail($this->faker->email);
            $user->setRoles(['ROLE_ADMIN']);
            $user->setPassword($this->userPasswordEncoder->encodePassword($user, 'engage'));
            $user->setUsername($this->faker->userName);
            $this->setDateTimes($user);

            return $user;
        });

        $this->createMany(25, 'anonymous_users', function() use($manager) {
           $user = new User();
           $user->setEmail($this->faker->email);
           $user->setRoles(['ROLE_USER']);
           $user->setPassword($this->userPasswordEncoder->encodePassword($user, 'engage'));
           $user->setUsername($this->faker->userName);
           $this->setDateTimes($user);

           return $user;
        });

        $manager->flush();
    }
}