<?php

namespace App\Form;

use App\Entity\TypeDesigner;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class TypeDesignerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'constraints'=> [
                    new Assert\NotBlank()
                ]
            ])
            ##TODO: Fix me save EntityTypes
            ->add('company_id', IntegerType::class, [
                'mapped' => false,
                'constraints'=> [
                    new Assert\NotBlank()
                ]
            ])
            ->add('type_designer_id', IntegerType::class, [
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
            'data_class' => TypeDesigner::class,
        ]);
    }
}
