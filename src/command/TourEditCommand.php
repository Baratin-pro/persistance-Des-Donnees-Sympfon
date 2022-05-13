<?php

namespace App\Command;

use App\Repository\TourRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/* #[AsCommand(
    name: 'tour:edit',
    description: 'Modification d\'un tour',
)] */
class TourEditCommand extends Command
{
    private $tourRepository;
    private $entityManager;

    public function __construct(TourRepository $tourRepository, EntityManagerInterface $entityManager) {
        parent::__construct();
        $this->tourRepository = $tourRepository;
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this
            ->addOption('tourId', null, InputOption::VALUE_REQUIRED, 'Id du tour à modifier')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $tourRepository = $this->tourRepository;

        $tourId = $input->getOption('tourId');
        $tour = $tourRepository->find($tourId);

        if ($tour) {
            $newMainEvent = $io->ask('Nouveau nom : ', $tour->getMainEvent());
            $tour->setMainEvent($newMainEvent);


            $this->entityManager->flush();
        } else {
            $io->error('Tour inexistant !');
        }





        //$io->success('Le port a bien été modifié');

        return Command::SUCCESS;
    }
}