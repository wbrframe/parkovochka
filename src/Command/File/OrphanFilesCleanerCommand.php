<?php

declare(strict_types=1);

namespace App\Command\File;

use App\Command\AbstractBaseCommand;
use App\Repository\File\FileRepository;
use StfalconStudio\ApiBundle\Traits\EntityManagerTrait;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'app:file:remove-orphans', description: 'Removes orphan files')]
final class OrphanFilesCleanerCommand extends Command
{
    use EntityManagerTrait;
    use LockableTrait;

    public function __construct(private readonly FileRepository $fileRepository)
    {
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$this->lock(self::getDefaultName())) {
            $output->writeln('The command is already running in another process.');

            return self::SUCCESS;
        }

        $io = new SymfonyStyle($input, $output);
        $io->title('Removing expired orphan files...');

        $currentDateTime = new \DateTimeImmutable('now');
        $files = $this->fileRepository->findOrphans($currentDateTime, '-6 months');
        $count = \count($files);

        $io->writeln(sprintf('Total expired files: %d', $count));

        if ($count > 0) {
            foreach ($files as $file) {
                $io->text(sprintf('- Removed `%s`; filename `%s`', $file->getId(), $file->getFile()->getName()));
                $this->em->remove($file); // At the filesystem layer the removal of the file is handled by VichUploader
            }

            $this->em->flush();
        }

        $this->release();

        $io->success('DONE');

        return self::SUCCESS;
    }
}
