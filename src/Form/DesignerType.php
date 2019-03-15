<?php

namespace App\Form;

use App\Entity\Designer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class DesignerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('lastName')
            ->add('age')
            ##TODO: Fix me
            ->add('company_id', IntegerType::class, [
                'mapped' => false,
                'constraints'=> [
                    new Assert\NotBlank()
                ]
            ])
            ->add('desing_type_id', IntegerType::class, [
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
            'data_class' => Designer::class,
        ]);
    }
}
