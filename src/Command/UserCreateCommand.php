<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:user-create',
    description: 'Create user with password',
)]
class UserCreateCommand extends Command
{
    public function __construct(private UserRepository $userRepository,private UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('username', InputArgument::REQUIRED, 'Username')
            ->addArgument('password', InputArgument::REQUIRED, 'Password')
            ->addArgument(
                'roles',
                InputArgument::REQUIRED | InputArgument::IS_ARRAY,
                'User roles(separate with space)'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $username = $input->getArgument('username');
        $password = $input->getArgument('password');
        $roles = $input->getArgument('roles');

        if ($this->userRepository->findByUsername($username))
        {
            $io->error('User already exists');
            return  Command::FAILURE;
        };
        $user = new User();

        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $password
        );

        $user->setUsername($username);
        $user->setPassword($hashedPassword);
        $user->setRoles($roles);
        $this->userRepository->save($user, true);

        $io->success('User was created with id' . $user->getId());
        $io->info(var_export($user, true));

        return Command::SUCCESS;
    }
}
