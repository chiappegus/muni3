<?php

namespace App\Form;

use App\Entity\Buffy;
use App\Entity\Pedido;
use App\Entity\Persona;
use App\Repository\PersonaRepository;
use Doctrine\ORM\Decorator\createQueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class PedidoType extends AbstractType
{

    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Persona|null $user */

        $user = $this->tokenStorage->getToken()->getUser();
        //dd($user);
        $ent_id = $user->getId();
        // dd($ent_id);

        $builder

            ->add('cantidad', IntegerType::class, [
                'attr' => array('Min' => 1, 'Max' => 200),
            ])
            ->add('PrecioPedido')
            ->add('restaurant')
            ->add('createdAt')
            ->add('updatedAt')
            //->add('menu')

            ->add('menu', EntityType::class, array(

                'class'         => Buffy::class,

                'query_builder' => function ($er) {

                    return $er->createQueryBuilder('p')

                    //->addSelect('a')
                        ->andWhere('p.areStock = 0')
                    // ->setParameter('val', $this->tokenStorage->getToken()->getUser()->getId())
                        ->orderBy('p.name', 'ASC')
                    ;

                },

                'choice_label'  => 'name',

            ))
            // ->add('Persona')

            // ->add('Persona', EntityType::class, ['class' => Persona::class,
            // ])
            ->add('Persona', EntityType::class, array(

                'class'         => Persona::class,

                'query_builder' => function (PersonaRepository $er) {

                    return $er->createQueryBuilder('p')

                    //->addSelect('a')
                        ->andWhere('p.id = :val')
                        ->setParameter('val', $this->tokenStorage->getToken()->getUser()->getId())
                        ->orderBy('p.nombre', 'ASC')
                    ;

                },

                'choice_label'  => 'nombre' . 'apellido',

            ))

        ;

        // ->add('Persona', EntityType::class, array(

        //     'class'        => Persona::class,

        //     'choice_label' => $user->getId(),
        //     // ])

        // ))

        // ->add('Persona', EntityType::class, [
        //     'class'         => Persona::class,
        //     'query_builder' => function (EntityRepository $er) {
        //         return $er->createQueryBuilder('u')
        //             ->where('u.id == $user.getId')
        //             ->orderBy('u.username', 'ASC');
        //     },
        //     'choice_label'  => 'username',
        // ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Pedido::class,

        ]);
    }
}
