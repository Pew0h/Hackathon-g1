<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class EditProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add("firstname", TextType::class, [
                'attr' => [
                    'placeholder' => 'Firstname'
                ]
            ])
            ->add("lastname", TextType::class, [
                'attr' => [
                    'placeholder' => 'Lastname'
                ]
            ])
            ->add("age", NumberType::class, [
                'attr' => [
                    'placeholder' => 'Age'
                ],

            ])
            ->add("height", NumberType::class, [
                'attr' => [
                    'placeholder' => 'Height'
                ]
            ])
            ->add("weight", NumberType::class, [
                'attr' => [
                    'placeholder' => 'Weight'
                ]
            ])
            ->add("latitude", TextType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'search-city-latitude'
                ]
            ])
            ->add("longitude", TextType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'search-city-longitude'
                ]
            ])
            ->add('city', TextType::class, [
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Type to search a city',
                    'autocomplete' => 'nope',
                    'class' => 'search-city-input refresh-by-lat-lon'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
