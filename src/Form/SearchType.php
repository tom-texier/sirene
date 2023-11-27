<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('query', TextType::class, [
                'required' => true,
                'label' => "Nom ou n° de SIRET de l'entreprise",
                'label_attr' => [
                    'style' => 'display: none;'
                ],
                'row_attr' => [
                    'class' => 'flex w-full'
                ],
                'attr' => [
                    'placeholder' => "Nom ou n° de SIRET de l'entreprise",
                    'class' => 'w-full flex rounded-md px-3 outline-0 focus-visible:outline-0 focus:outline-0'
                ]
            ])
        ;
    }
}
