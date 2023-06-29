<?php

namespace App\Command;

use App\Repository\TileRepository;
use App\Service\ImageService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:image:scale',
    description: 'Scale all images currently uploaded',
)]
class ScaleImageCommand extends Command
{
    public function __construct(
        private readonly ImageService $imageService,
        private readonly TileRepository $tileRepository
    ) {
        parent::__construct();
    }

    /**
     * {@inheritDoc}
     */
    protected function configure(): void
    {
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $progressBar = new ProgressBar($output);
        $progressBar->setFormat('[%bar%] %elapsed% (%memory%) - %message%');
        $progressBar->setMessage('Started on image scaling');
        $progressBar->start();
        $progressBar->advance();

        $iterator = $this->tileRepository->getIterator();

        $count = 0;
        foreach ($iterator as $tile) {
            ++$count;
            $progressBar->setMessage(sprintf('Tile id %s with image %s (total: %s)', $tile->getId(), $tile->getImage(), $count));
            $this->imageService->scaleDown($tile->getImage());
            $progressBar->advance();
        }
        $progressBar->finish();
        $output->writeln('');

        return Command::SUCCESS;
    }
}
