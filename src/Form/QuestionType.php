<?php

namespace App\Form;

use App\Entity\Question;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', null, [
                'label' => 'Ecrivez votre question :',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Votre question ne peut pas être vide.'
                    ]),
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'Votre question ne doit pas dépasser {{ limit }} caractères.'
                    ])
                ]
            ])
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'label' => 'Sélectionner une ou des catégories correspondant a votre question:',
                'multiple' => true,
                'expanded' => true,
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
