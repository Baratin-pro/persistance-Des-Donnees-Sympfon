<?php

namespace App\Command;

use App\Entity\Tour;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/* [AsCommand(
    name: 'tour:create', 
    description: 'Add a short description for your command',
)] */

class TourCreateCommand extends Command
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this
            ->addOption('tourMainEvent', null, InputOption::VALUE_REQUIRED, 'MainEvent of the tour')
            ->addOption('tourCapacity', null, InputOption::VALUE_REQUIRED, 'Capacity of the tour')
            ->addOption('tourPrice', null, InputOption::VALUE_REQUIRED, 'Price of the tour')
            ->addOption('tourStartDate', null, InputOption::VALUE_REQUIRED, 'StartDate of the tour')
            ->addOption('tourStopDate', null, InputOption::VALUE_REQUIRED, 'StopDate of the tour')
            ->addOption('tourCompagny_id', null, InputOption::VALUE_REQUIRED, 'Compagny_id of the tour')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $tourMainEvent = $input->getOption('tourMainEvent');
        $tourCapacity = $input->getOption('tourCapacity');
        $tourPrice = $input->getOption('tourPrice');
        $tourStartDate = $input->getOption('tourStartDate');
        $tourStopDate = $input->getOption('tourStopDate');
        $tourCompagny_id = $input->getOption('tourCompagny_id');


        #$io->writeln('Le tour est : '.$tourMainEvent);

        $tour = new Tour();
        $tour->setMainEvent($tourMainEvent);
        $tour->setCapacity($tourCapacity);
        $tour->setPrice($tourPrice);
        $tour->setStartDate($tourStartDate);
        $tour->setStopDate($tourStopDate);
        $tour->setCompagny($tourCompagny_id);

        $this->entityManager->persist($tour);
        $this->entityManager->flush();

        $io->success('Le tour '.$tourMainEvent.' est créé');

        return Command::SUCCESS;
    }
}