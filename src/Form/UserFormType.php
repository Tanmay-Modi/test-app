<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
       
        $builder
            ->add('name', TextType::class, [
                'attr' => ['placeholder' => 'Enter Name'],
                'required' => true,

            ])
            ->add('email', EmailType::class, [
                'attr' => ['placeholder' => 'Enter Email','class' => 'form-control'],
                'help'        => 'test@hello.com',

            ])
            ->add('password', PasswordType::class, [
                'attr' => ['placeholder' => 'Enter Password','class' => 'form-control'],
                'help'        => 'admin@123',
            ])
            ->add('gender', ChoiceType::class, [
                'attr' => ['placeholder' => 'Enter Gender','class' => 'form-control'],
                'choices'  => [
                    'Male' => 'male',
                    'female' => 'female',
                    'other' => 'other',
                ],

                'help'        => 'male',
            ])

            ->add('phone', TelType::class, [
                'attr' => ['placeholder' => 'Enter Phone','class' => 'form-control'],
            ]);

            // Only add the password field if it's a new user being created
        if ($options['is_edit']) {
            $builder->remove('password');
        } else {
            $builder->add('password');
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'is_edit' => false,
        ]);
    }
}
