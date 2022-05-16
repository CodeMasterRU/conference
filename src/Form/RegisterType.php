<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;


class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        
        $builder
        ->add('firstname', TextType::class, [
            'label'=> "FIRSTNAME",
            'constraints' => new Length([
                'min' => 2,
                'max' => 30
            ]),
            'attr' => [
                'placeholder' => 'votre firstname'
            ]
        ])
        ->add('lastname', TextType::class, [
            'label' => "LASTNAME",
            'constraints' => new Length([
                'min' => 2,
                'max' => 30
            ]),
            'attr' => [
                'placeholder' => 'votre lastname'
            ]
        ]) 
        ->add('email', EmailType::class, [
            'constraints' => new Length([
                'min' => 2,
                'max' => 30
            ]),
            'label' => "Email",
            'attr' => [
                'placeholder' => 'votre mail'
                ]
        ])
        ->add('password', RepeatedType::class, [
            'type' => PasswordType::class,
            'invalid_message' => 'non indentique',
            'label' => "PASSWD",
            'required' => true,
            'first_options' => [
                'label' => 'Votre mot de passe',
                'attr' => [
                    'placeholder' => 'votre mot de passe'
                ]
            ],
            'second_options' => [
                'label' => 'Confirmer votre mot de passe',
                'attr' => [
                    'placeholder' => 'confirmer votre mot de passe'
                ]
            ],
            
        ])
        ->add('submit', SubmitType::class, [
            'label' => "S'inscrire",
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
