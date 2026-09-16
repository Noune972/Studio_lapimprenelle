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
            ->setDefaultSort(['createdAt' => 'DESC']);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('titre'),
            SlugField::new('slug')->setTargetFieldName('titre'),
            TextareaField::new('description'),
            ChoiceField::new('type_de_site')
            ->setLabel('Type de site')
            ->setChoices([
            'WordPress' => 'wordpress',
            'Symfony' => 'symfony',
             ]),
            ImageField::new('image')
                ->setUploadDir('public/images')
                ->setBasePath('images')
                ->setRequired(false),
            UrlField::new('lien')
                ->setRequired(false)
                ->setHelp('Lien vers le site en ligne, si disponible.'),
            DateTimeField::new('createdAt')
                ->setLabel('Date de création')
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