<?php

namespace App\Form;

use App\Entity\Billets;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use App\Form\ReservationType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class BilletsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nom', TextType::class)
        ->add('prenom', TextType::class)
        ->add('naissance', BirthdayType::class, [
            'label' => 'Votre date de naissance',
            'placeholder' => [
                'day' => 'Jour',
                'month' => 'Mois',
                'year' => 'Année',
            ],
            'format' => 'dd-MM-yyyy'
        ])
        ->add('pays', CountryType::class)
        ->add('reduction')
    ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Billets::class,
        ]);
    }
}
