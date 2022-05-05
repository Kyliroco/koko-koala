<?php

namespace App\Controller\Admin;

use App\Entity\Exercice;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ExerciceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Exercice::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('matiere'),
            AssociationField::new('classe'),
            AssociationField::new('categorie'),
            TextField::new('nom'),
            BooleanField::new('visible'),
            TextField::new('lien'),
        ];
    }
}
