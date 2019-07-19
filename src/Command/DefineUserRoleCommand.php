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

class DefineUserRoleCommand extends Command
{
    protected static $defaultName = 'app:define-role';

    private $io;
    private $em;
    private $users;

    public function __construct(string $name = null, EntityManagerInterface $entityManager)
    {
        parent::__construct($name);
        $this->em = $entityManager;
        $this->users = $entityManager->getRepository(User::class)->findAll();
    }

    protected function configure()
    {
        $this
            ->setDescription('Gestion des rôles utilisateurs')
            ->setHelp('Cette commande permet de gérer les utilisateurs et de leur attribuer des rôles');

        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->io = new SymfonyStyle($input, $output);
        $this->io->title('Bienvenue dans le gestionnaire des utilisateurs');

        $this->displayMenu();
    }

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
        // Récuperation de l'id user
        $id = $this->io->ask('Saisissez un Utilisateur id');
        $user = $this->em->getRepository(User::class)->find($id);

        if (!$user) {
            $this->io->error("L'id $id n'existe pas !");
            return;
        }

        // Définition des rôles
        $roles = [
            'ROLE_USER',
            'ROLE_ADMIN',
            'ROLE_SUPERADMIN'
        ];

        // Attribution des rôles
        $role = $this->io->choice(
            'Quel rôle souhaitez-vous attribuer ?',
            array_diff($roles, $user->getRoles()));

        // Si un user dispose déjà de ce rôle:
        if (!$user->addRole($role)) {
            $this->io->caution('Cet utilisateur à déjà ce rôle.');
        } else {

            // Ajouter en db le rôle lié à l'user
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
        // Récuperation de l'id user
        $id = $this->io->ask('Saisissez un Utilisateur id');
        $user = $this->em->getRepository(User::class)->find($id);

        if (!$user) {
            $this->io->error("L'id $id n'existe pas !");
            return;
        }

        // Définition des rôles
        $roles = [
            'ROLE_USER',
            'ROLE_ADMIN',
            'ROLE_SUPERADMIN'
        ];

        // Attribution des rôles
        $role = $this->io->choice(
            'Quel rôle souhaitez-vous retirer ?',
            array_intersect($roles, $user->getRoles()));

        // Retirer en db le rôle lié à l'user
            $user->removeRole($role);
            $this->em->flush();

            $this->io->success("Le rôle $role a bien été retiré à " . $user->getEmail());
        //}
    }

}
