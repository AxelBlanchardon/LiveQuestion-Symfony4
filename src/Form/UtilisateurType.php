<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;


class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('pseudo')
            ->add('avatar', AvatarType::class, [
                'label' => 'Choisissez un avatar si vous le souhaitez :'
            ])
            ->add('plainPassword',  RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => false,
                'options' => ['attr' => ['class' => 'password-field']],
                'first_options'  => ['label' => 'Entrez le nouveau mot de passe : '],
                'second_options' => ['label' => 'Repetez le mot de passe : '],
                'invalid_message' => 'Les mots de passe ne correspondent pas',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
