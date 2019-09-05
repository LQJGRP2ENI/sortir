<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModifierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class,[
                "error_bubbling"=>true,
                "trim"=>true,
                "label"=>"Votre pseudo",
                "required"=>true
            ])
            ->add('email', EmailType::class,[
                 "error_bubbling"=>true,
                "label"=>"Votre email"
            ])
            ->add('password', PasswordType::class,[
                "error_bubbling"=>true,
                "trim"=>true,
                "label"=>"Votre mot de passe",
                "required"=>true
            ])
            ->add('nom', TextType::class,[
                "error_bubbling"=>true,
                "trim"=>true,
                "label"=>"Votre nom",
                "required"=>false
            ])
            ->add('prenom', TextType::class,[
                "error_bubbling"=>true,
                "trim"=>true,
                "label"=>"Votre prénom",
                "required"=>false
            ])
            ->add('telephone', TextType::class,[
                "error_bubbling"=>true,
                "trim"=>true,
                "label"=>"Votre numéro de téléphone",
                "required"=>false
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
