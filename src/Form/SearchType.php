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
                    'class' => 'block text-sm font-medium leading-6 text-white',
                    'style' => 'display: none;'
                ],
                'row_attr' => [
                    'class' => 'flex'
                ],
                'attr' => [
                    'placeholder' => "Nom ou n° de SIRET de l'entreprise",
                    'class' => 'flex w-full rounded-md border-0 py-1 px-3'
                ]
            ])
        ;
    }
}
