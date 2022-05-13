<?php

namespace App\Command;

use App\Repository\TourRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/* #[AsCommand(
    name: 'tour:list',
    description: 'Permet de lister les tours d'une compagnie',
)] */

class TourListCommand extends Command
{
    private $tourRepository;

    public function __construct(TourRepository $tourRepository) {
        parent::__construct();
        $this->tourRepository = $tourRepository;
    }

    protected function configure(): void
    {
        $this->addOption('compagny_id', null, InputOption::VALUE_REQUIRED, 'Id de la compagnie a afficher');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $tourRepository = $this->tourRepository;

        $tourCompagnie_id = $input->getOption('compagny_id');
        $tours = $tourRepository-> findBy(array('compagny_id' => $tourCompagnie_id ));

        $table = new Table($output);
        $table->setHeaders(['Id', 'MainEvent', 'Capacity', 'Price', 'StartDate', 'StopDate']);

        foreach ($tours as $tour) {
            $table->addRow([$tour->getId(), $tour->getMainEvent(), $tour->getCapacity(), $tour->getPrice(), $tour->getStartDate(), $tour->getStopDate()]);
        }

        $table->render();

        return Command::SUCCESS;
    }
}