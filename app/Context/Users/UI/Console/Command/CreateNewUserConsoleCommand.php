<?php

declare(strict_types=1);

namespace App\Context\Users\UI\Console\Command;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use App\Context\Users\UI\Validator\NewUserValidator;
use Symfony\Component\Console\Input\InputDefinition;
use Cordo\Core\UI\Console\Command\BaseConsoleCommand;
use Symfony\Component\Console\Output\OutputInterface;
use App\Context\Users\Application\Command\CreateNewUser;

#[AsCommand(name: 'context:create-user')]
class CreateNewUserConsoleCommand extends BaseConsoleCommand
{
    protected function configure()
    {
        $this
            ->setDescription('Creates a new user.')
            ->setHelp('This command allows you to create a user.')
            ->setDefinition(
                new InputDefinition([
                    new InputArgument('email', InputArgument::REQUIRED),
                    new InputArgument('password', InputArgument::REQUIRED),
                ])
            )
            ->addOption('lang', null, InputOption::VALUE_REQUIRED, 'Language');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $params = $input->getArguments();
        $service = $this->container->get('context.users.query.service');

        $validator = new NewUserValidator($service, $params);

        if ($validator->fails()) {
            array_map(static function ($message) use ($output) {
                $output->write('<error>');
                $output->writeln($message);
                $output->write('</error>');
            }, $validator->messages()->toArray());
            exit;
        }

        $params = (object) $params;

        $command = new CreateNewUser(
            (string) $params->email,
            (string) $params->password
        );

        $this->commandBus->handle($command);

        $output->writeln('<info>User successfully created.</info>');

        return 0;
    }
}
