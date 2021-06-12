<?php

namespace Architecture\Application\UseCases\Command\Swagger\Link;

use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class LinkCommand extends Command
{
    const SWAGGER_UI_DIST_DIR = 'swagger-api/swagger-ui/dist';
    const BUNDLE_PUBLIC_DIR = 'harmbandstra/swagger-ui-bundle/src/Resources/public';

    protected static $defaultName = 'swagger:link-assets';

    protected $vendorDir;

    public function __construct(string $projectDir)
    {
        parent::__construct(null);
        $this->vendorDir = $projectDir . '/vendor/';
    }

    protected function configure()
    {
        $this->setDescription('Add a short description for your command');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->text('Start link assets');

        try {
            $filesystem = new Filesystem();
            $source = sprintf('%s/%s', $this->vendorDir, self::SWAGGER_UI_DIST_DIR);
            $target = sprintf('%s/%s', $this->vendorDir, self::BUNDLE_PUBLIC_DIR);
            $filesIterator = new Finder();
            $filesIterator->files()->in($source)->notName('*.map');
            $filesystem->mirror($source, $target, $filesIterator, ['override' => true]);
            $io->success('Complete!');

            return 0;
        } catch (Exception $exception) {
            $io->error($exception->getMessage());
            return 1;
        }
    }
}
