<?php

namespace App\Controller\Admin;

use App\Entity\Projet;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class ProjetCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Projet::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Projet')
            ->setEntityLabelInPlural('Projets')
            ->setDefaultSort([
                'createdAt' => 'DESC',
            ]);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('titre', 'Titre'),

            SlugField::new('slug', 'Slug')
                ->setTargetFieldName('titre'),

            TextareaField::new('description', 'Description'),

            ChoiceField::new('type_de_site', 'Type de site')
                ->setChoices([
                    'WordPress' => 'wordpress',
                    'Symfony' => 'symfony',
                ]),

            ImageField::new('image', 'Capture du site')
                ->setUploadDir('public/uploads/projets')
                ->setBasePath('uploads/projets')
                ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]')
                ->setRequired(false)
                ->setHelp(
                    'Ajoutez une capture d’écran du site. Elle sera affichée dans le mockup ordinateur.'
                ),

            UrlField::new('lien', 'Lien du site')
                ->setRequired(false)
                ->setHelp('Lien vers le site en ligne, si disponible.'),

            DateTimeField::new('createdAt', 'Date de création')
                ->hideOnForm(),
        ];
    }

    public function createEntity(string $entityFqcn): object
    {
        $projet = new Projet();

        $projet->setCreatedAt(new \DateTimeImmutable());

        return $projet;
    }
}