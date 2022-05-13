<?php

namespace App\Command;

use App\Entity\Compagny;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/* [AsCommand(
    name: 'compagny:create', 
    description: 'Add a short description for your command',
)] */

class CompagnyCreateCommand extends Command
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this
            ->addOption('compagnyName', null, InputOption::VALUE_REQUIRED, 'Name of the compagny')
            ->addOption('compagnyNationality', null, InputOption::VALUE_REQUIRED, 'Nationality of the compagny')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $compagnyName = $input->getOption('compagnyName');
        $comapgnyNationality = $input->getOption('comapgnyNationality');

        #$io->writeln('Le nom de la compagnie est : '.$compagnyName);
        #$io->writeln('Il est de nationalité : '.$comapgnyNationality);

        $harbor = new Compagny();
        $harbor->setName($compagnyName);
        $harbor->setNationality($comapgnyNationality);

        $this->entityManager->persist($harbor);
        $this->entityManager->flush();

        $io->success('La compagnie '.$compagnyName.' est créé');

        return Command::SUCCESS;
    }
}