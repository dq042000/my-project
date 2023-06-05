<?php

namespace Base\Command;

use Base\Model\DefaultData;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class Install extends Command
{

    protected $serviceManager;

    /** @var   \Doctrine\Orm\EntityManagerInterface */
    protected $em;

    /**
     * 預設資料
     * @var DefaultData
     */
    protected $defaultData;

    protected function configure()
    {
        $this
            ->addArgument('re-create-database', InputArgument::OPTIONAL, '重建資料庫')
            ->setDescription('安裝系統')
            ->setHelp(<<<'EOF'
            安裝系統:
                <info>base:install</info>

            重建資料庫:
                <info>base:install re-create-database</info>
            EOF
            )
        ;
    }

    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->serviceManager = $container;
        $this->em = $this->serviceManager->get('doctrine.entitymanager.orm_default');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $recreateDatabase = $input->getArgument('re-create-database');
        $schemaTool = new \Doctrine\ORM\Tools\SchemaTool ($this->em);

        $output->writeln('建立資料表中, 請稍待!!');
        $classes = $this->em->getMetadataFactory()->getAllMetadata();
        echo "<pre>";
        print_r($classes);
        echo "</pre>";
        exit;

        if ($recreateDatabase === 're-create-database') {
            $schemaTool->dropSchema($classes);
        }

        $schemaTool->createSchema($classes);

        $output->writeln('<bg=blue;options=bold>=============================</>');
        $output->writeln('建立完成');

        return 0;
    }
}
