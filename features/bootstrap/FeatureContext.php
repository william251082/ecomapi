<?php

use Behat\Behat\Context\Context;

class FeatureContext extends \Behatch\Context\RestContext
{
    /**
     * @var \App\DataFixtures\AppFixtures
     */
    private $fixtures;

    /**
     * @var \Coduo\PHPMatcher\Matcher
     */
    private $matcher;

    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    private $manager;

    public function __construct(
        \Behatch\HttpCall\Request $request,
        \App\DataFixtures\AppFixtures $fixtures,
        \Doctrine\ORM\EntityManagerInterface $manager
    )
    {
        parent::__construct($request);
        $this->fixtures = $fixtures;
        $this->matcher =
            (new \Coduo\PHPMatcher\Factory\SimpleFactory())->createMatcher();
        $this->manager = $manager;
    }

    /**
     * @BeforeScenario @createSchema
     */
    public function createSchema()
    {
        // Get entity metadata
        $classes = $this->manager->getMetadataFactory()->getAllMetaData();

        // Drop and create schema
        $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($this->manager);
        $schemaTool->dropSchema($classes);
        $schemaTool->createSchema($classes);

        // Load fixtures and execute
        $purger = new \Doctrine\Common\DataFixtures\Purger\ORMPurger($this->manager);

        $fixturesExecutor = new \Doctrine\Common\DataFixtures\Executor\ORMExecutor($this->manager, $purger);
        $fixturesExecutor->execute([
            $this->fixtures
        ]);

    }
}