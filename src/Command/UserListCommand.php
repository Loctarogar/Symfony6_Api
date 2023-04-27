<?php

namespace App\Command;

use App\Repository\UserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;

#[AsCommand(
    name: 'app:user-list',
    description: 'Users list',
)]
class UserListCommand extends Command
{
    public function __construct(private UserRepository $userRepository)
    {
        parent::__construct();
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $table = new Table($output);
        $users = $this->userRepository->findAll();
        $table->setHeaders(["Id", "Username", "Roles"]);
        $table->setRows(array_map(fn (User $user)=> [
            $user->getId(),
            $user->getUsername(),
            implode(',', $user->getRoles()),
        ], $users));
        $table->render();

        return Command::SUCCESS;
    }
}
