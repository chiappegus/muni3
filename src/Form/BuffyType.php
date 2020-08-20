<?php

namespace App\Form;

use App\Entity\Buffy;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BuffyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('stock')
            ->add('precio')
            ->add('areStock', HiddenType::class, ['attr' => ['checked' => true, 'value' => 0]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Buffy::class,
        ]);
    }
}
