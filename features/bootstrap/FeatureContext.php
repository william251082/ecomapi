<?php

use Behatch\Context\RestContext;

class FeatureContext extends RestContext
{
    /**
     * @var \Coduo\PHPMatcher\Matcher
     */
    private $matcher;

    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    private $manager;
    /**
     * @var \App\DataFixtures\ProductFixtures
     */
    private $productFixtures;
    /**
     * @var \App\DataFixtures\TaxonFixtures
     */
    private $taxonFixtures;
    /**
     * @var \App\DataFixtures\UserFixtures
     */
    private $userFixtures;

    public function __construct(
        \Behatch\HttpCall\Request $request,
        \App\DataFixtures\ProductFixtures $productFixtures,
        \App\DataFixtures\TaxonFixtures $taxonFixtures,
        \App\DataFixtures\UserFixtures $userFixtures,
        \Doctrine\ORM\EntityManagerInterface $manager
    )
    {
        parent::__construct($request);
        $this->matcher =
            (new \Coduo\PHPMatcher\Factory\SimpleFactory())->createMatcher();
        $this->manager = $manager;
        $this->productFixtures = $productFixtures;
        $this->taxonFixtures = $taxonFixtures;
        $this->userFixtures = $userFixtures;
    }

    /**
     * @BeforeScenario @createSchema
     * @throws \Doctrine\ORM\Tools\ToolsException
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
            $this->productFixtures,
            $this->taxonFixtures,
            $this->userFixtures
        ]);

    }
}