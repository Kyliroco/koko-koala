<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('classe'),
            TextField::new('username'),
            TextField::new('prenom'),
            TextField::new('mail'),
            TextField::new('ville'),
            TextField::new('code_postal'),
            TextField::new('civilite'),
        ];
    }
}