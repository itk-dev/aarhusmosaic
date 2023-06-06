<?php

namespace App\Command;

use App\Repository\TileRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

#[AsCommand(
    name: 'app:image:unused-remove',
    description: 'Remove images that is not in the database',
)]
class RemoveUnusedImagesCommand extends Command
{
    public function __construct(
        private readonly TileRepository $tileRepository,
        private readonly string $imagePath
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
        $finder = new Finder();
        $finder->files()->in($this->imagePath);

        $count = 0;
        foreach ($finder as $file) {
            $absolutePath = $file->getRealPath();
            $filename = $file->getFilename();

            $tile = $this->tileRepository->findOneBy(['image' => $filename]);
            if (is_null($tile)) {
                unlink($absolutePath);
                ++$count;
                $output->write('.');
            }
        }
        $output->writeln('');
        $output->writeln(sprintf('Removed %s unused images.', $count));

        return Command::SUCCESS;
    }
}
