<?php

namespace App\Form;

use App\Entity\Company;
use App\Entity\Developer;
use App\Entity\Language;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;


class DeveloperType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'constraints'=> [
                    new Assert\NotBlank()
                ]
            ])
            ->add('lastName', TextType::class, [
                'constraints'=> [
                    new Assert\NotBlank()
                ]
            ])
            ->add('age', IntegerType::class, [
                'constraints'=> [
                    new Assert\NotBlank()
                ]
            ])
            ##TODO: Fix me
            ->add('company_id', IntegerType::class, [
                'mapped' => false,
                'constraints'=> [
                    new Assert\NotBlank()
                ]
            ])
            ->add('language_id', IntegerType::class, [
                'mapped' => false,
                'constraints'=> [
                    new Assert\NotBlank()
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Developer::class,
        ]);
    }
}
