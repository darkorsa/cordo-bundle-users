<?php

namespace Cordo\Bundle\Users;

use Cordo\Core\Application\App;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputDefinition;
use Cordo\Core\UI\Console\Command\BaseConsoleCommand;
use Symfony\Component\Console\Output\OutputInterface;
use Cordo\Core\Application\Service\Bundle\BundleInstaller;
use Cordo\Core\Application\Service\Bundle\BundleInstallerException;

#[AsCommand(name: 'cordo-bundle-users:install')]
class InstallCommand extends BaseConsoleCommand
{
    private const DEFAULT_CONTEXT = 'Context';

    protected function configure()
    {
        $this
            ->setDescription('Install users bundle.')
            ->setHelp('Copies files, registers modules and updates schema.')
            ->setDefinition(
                new InputDefinition([
                    new InputArgument('context', InputArgument::REQUIRED),
                ])
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $params = (object) $input->getArguments();

        $rootPath = realpath(dirname(__FILE__) . '/../app/' . self::DEFAULT_CONTEXT . '/');
        $targetPath = App::rootPath("app/{$params->context}");

        try {
            $installer = new BundleInstaller($rootPath, $targetPath, self::DEFAULT_CONTEXT, $params->context);
            $installer->copyFiles();
            $installer->createSchema(
                "App\\{$params->context}\\Users\Domain\User",
            );
        } catch (BundleInstallerException $e) {
            $output->writeln("<error>{$e->getMessage()}</error>");
            return 0;
        }

        return 0;
    }
}
