<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom complet',
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse email',
            ])
            ->add('telephone', TelType::class, [
                'label' => 'Téléphone',
                'required' => false,
            ])
            ->add('typeProjet', ChoiceType::class, [
                'label' => 'Type de projet',
                'choices' => [
                    'Site WordPress' => 'wordpress',
                    'Application Symfony' => 'symfony',
                    'Refonte / maintenance' => 'refonte',
                    'Je ne sais pas encore' => 'autre',
                ],
            ])
            ->add('budget', ChoiceType::class, [
                'label' => 'Budget indicatif',
                'required' => false,
                'placeholder' => 'Sélectionnez une fourchette',
                'choices' => [
                    'Moins de 1 500 €' => 'moins-1500',
                    '1 500 € — 5 000 €' => '1500-5000',
                    '5 000 € — 10 000 €' => '5000-10000',
                    'Plus de 10 000 €' => 'plus-1000',
                ],
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Parlez-moi de votre projet',
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}