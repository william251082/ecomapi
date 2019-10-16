<?php

namespace App\Command;

use App\Entity\Product;
use App\Entity\Taxon;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CsvImportCommand extends Command
{
    protected static $defaultName = 'csv:import';

    /**
     * @var EntityManagerInterface
     */
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        parent::__construct();
        $this->manager = $manager;
    }

    protected function configure()
    {
        $this
            ->setDescription('CSV importer')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Attempting import of Feed...');

        $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
            // ...
        }

        $reader = Reader::createFromPath('/home/iceshop/Sites/ecomapi/data/Products.csv', 'r');
        $reader->setHeaderOffset(0);

        $header = $reader->getHeader();
        $records = $reader->getRecords();
        $results = $reader->getContent();

        $io->progressStart(count([$records]));

        $user = new User();
        $user->setUsername('john');
        $user->setEmail('john@doe.com');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword('engage');
        $user->setCreatedAt(new \DateTime());
        $user->setUpdatedAt(new \DateTime());

        $taxon = new Taxon();
        $taxon->setTitle('title');
        $taxon->setUpdatedAt(new \DateTime());
        $taxon->setContent('content');
        $taxon->setSlug('slug');
        $taxon->setPublishedAt(new \DateTime());
        $taxon->setCreatedAt(new \DateTime());
        $taxon->setUpdatedAt(new \DateTime());
        $taxon->setAuthor($user);

        $this->manager->persist($user);
        $this->manager->persist($taxon);

        foreach ($records as $row) {
            $product = new Product();
            $product->setOwner($user);
            $product->setName($row['name']);
            $product->setDescription($row['description']);
            $product->setPrice($row['price']);
            $product->setIsPublished($row['is_published']);
            $product->setCreatedAt(new \DateTime($row['created_at']));
            $product->setUpdatedAt(new \DateTime($row['updated_at']));
            $product->setTaxon($taxon);

            $this->manager->persist($product);
            $io->progressAdvance();
        }

        $this->manager->flush();

        $io->progressFinish();
        $io->success('Command exited cleanly!');
    }
}
