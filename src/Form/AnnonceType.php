<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Annonce;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('uri')
            ->add('description')
            ->add('photo')
            ->add('datePublication')
            ->add('user', EntityType::class, [ 
                                'class' => User::class, 
                                'choice_label' => 'email', 
                                'expanded' => true,
                                // 'multiple' => true,
                                // https://symfony.com/doc/current/reference/forms/types/entity.html#basic-usage
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
