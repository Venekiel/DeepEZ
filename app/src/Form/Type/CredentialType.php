<?php

namespace App\Form\Type;

use App\Entity\Credential;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CredentialType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('username', TextType::class, [
                'required' => false,
                'attr' => [
                    'readonly' => $options['readonly'],
                ],
            ])
            ->add('password', PasswordType::class, [
                'required' => false,
                'always_empty' => false,
                'attr' => [
                    'readonly' => $options['readonly'],
                    'autocomplete' => 'off',
                    'value' => $options['data']->getPassword(),
                ],
            ])
            ->add('link', TextType::class, [
                'required' => false,
                'attr' => [
                    'readonly' => $options['readonly'],
                ],
            ])
        ;

        if($options['readonly'] === false) {
            $builder->add('register', SubmitType::class, ['label' => 'Register credential']);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Credential::class,
            'readonly' => false,
        ]);
    }
}
