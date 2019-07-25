<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class DefineUserRoleCommand
 * @package App\Command
 */
class DefineUserRoleCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:define-role';

    /**
     * @var
     */
    private $io;
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var User[]|object[]
     */
    private $users;

    /**
     * DefineUserRoleCommand constructor.
     * @param string|null $name
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(string $name = null, EntityManagerInterface $entityManager)
    {
        parent::__construct($name);
        $this->em = $entityManager;
        $this->users = $entityManager->getRepository(User::class)->findAll();
    }

    protected function configure()
    {
        $this
            ->setDescription('Manage roles for users ')
            ->setHelp('Cette commande permet de gérer les utilisateurs et de leur attribuer des rôles');

        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->io = new SymfonyStyle($input, $output);
        $this->io->title('Bienvenue dans le gestionnaire des utilisateurs');

        $this->displayMenu();
    }


    /**
     * Displays menu into console
     */
    private function displayMenu()
    {
        while (true) {
            $input = $this->io->choice(
                'Sélectionnez une action',
                [
                    'Afficher la liste des utilisateurs',
                    'Ajouter un rôle (Nécessite un ID Utilisateur)',
                    'Retirer un rôle (Nécessite un ID Utilisateur)',
                    'Quitter'
                ]
            );

            switch ($input) {
                case 'Afficher la liste des utilisateurs':
                    $this->displayUserList();
                    break;
                case 'Ajouter un rôle (Nécessite un ID Utilisateur)':
                    $this->addUserRole();
                    break;
                case 'Retirer un rôle (Nécessite un ID Utilisateur)':
                    $this->removeUserRole();
                    break;
                case 'Quitter':
                    exit();
                    break;
            }
        }
    }

    /**
     * Displays a users list into the console
     */
        private function displayUserList()
    {
        $display = [];

        foreach ($this->users as &$user) {
            $display[] = [
                $user->getId(),
                $user->getFirstname() . ' ' . $user->getLastname(),
                $user->getEmail(),
                join(' + ', $user->getRoles())
            ];
        }
        $this->io->table(['ID', 'FULLNAME', 'EMAIL', 'ROLES'], $display);
    }

    /**
     * Find a user identification and allows to add a user's role
     */
    private function addUserRole()
    {
        // Find user's id
        $id = $this->io->ask('Saisissez un Utilisateur id');
        $user = $this->em->getRepository(User::class)->find($id);

        if (!$user) {
            $this->io->error("L'id $id n'existe pas !");
            return;
        }

        // Define roles
        $roles = [
            'ROLE_USER',
            'ROLE_ADMIN',
            'ROLE_SUPERADMIN'
        ];

        // Assignment roles
        $role = $this->io->choice(
            'Quel rôle souhaitez-vous attribuer ?',
            array_diff($roles, $user->getRoles()));

        // If a user already have a role
        if (!$user->addRole($role)) {
            $this->io->caution('Cet utilisateur à déjà ce rôle.');
        } else {

            // Add user's role in db
            $user->addRole($role);
            $this->em->flush();
            
            $this->io->success("Le rôle $role a bien été attribué à " . $user->getEmail());
        }
    }

    /**
     * Find a user identification and allows to add a user's role
     */
    private function removeUserRole()
    {
        // Find user's id
        $id = $this->io->ask('Saisissez un Utilisateur id');
        $user = $this->em->getRepository(User::class)->find($id);

        if (!$user) {
            $this->io->error("L'id $id n'existe pas !");
            return;
        }

        // Define roles
        $roles = [
            'ROLE_USER',
            'ROLE_ADMIN',
            'ROLE_SUPERADMIN'
        ];

        // Unset a role
        $role = $this->io->choice(
            'Quel rôle souhaitez-vous retirer ?',
            array_intersect($roles, $user->getRoles()));


            $user->removeRole($role);
            $this->em->flush();

            $this->io->success("Le rôle $role a bien été retiré à " . $user->getEmail());
    }

}
