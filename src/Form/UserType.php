<?php

namespace App\Form;

use App\Entity\Role;
use App\Entity\User;
use App\Repository\RoleRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userName')
            ->add('email')
            ->add('picture')
            //->add('dateInscription')
            ->add('password')
            ->add('userRoles', EntityType::class,[
                'multiple' => true,
                'class' => Role::class,
                'query_builder' => function (RoleRepository $repo) {
                    return $repo->createQueryBuilder('r')
                        ->orderBy('r.title', 'ASC');
                },
                'choice_label' => 'title'
            ])
            ->add('job');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
