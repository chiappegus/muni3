<?php

namespace App\DataFixtures;

use App\Entity\ApiToken;
use App\Entity\Buffy;
use App\Entity\Pedido;
use App\Entity\Persona;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    public function load(ObjectManager $manager)
    {

        $comida = ["TORTILLA DE PATATAS",
            "PIZZA(Italia)",
            "HUEVOS FRITOS CON CHORIZO(España)",
            "BOCATA DE CALAMARES(España)",
            "SPAGUETTI CARBONARA (Italia)",
            "SÁNDWICH(Inglaterra)",
            "SAN JACOBO (Suiza)",
            "TARTA SACHER (Austria)",
            "SUSHI (Japón)",
            "ROLLITOS DE PRIMAVERA (China)",
            "MOUSSAKA (Grecia)",
            "LA FONDUE (Suiza)",
            "SARDINHAS ASSADAS (Portugal)",
            "CREPES (Francia)",
            "FALAFEL (Egipto)",
            "FISH AND CHIPS (Inglaterra)",
            "CHORIPÁN (Argentina)",
            "CEVICHE DE CAMARÓN (Ecuador)",
            "AREPAS (Colombia)",

        ];

        $precio_ = [200, 650, 450, 850, 550, 390, 1500, 290, 1900, 250];

        for ($i = 0; $i < 10; $i++) {

            $buffy = new Buffy();
            $buffy->setName($comida[$i]);

            $buffy->setStock($i + 20);
            $buffy->setPrecio($precio_[$i]);
            //$buffy->setNombre($this->faker->firstName);

            $manager->persist($buffy);

        };

        $i    = 0;
        $user = new Persona();
        $user->setEmail(sprintf('gust%d@gus.com', $i));
        $user->setNombre(sprintf('gust%d', $i));
        $user->setApellido(sprintf('gust%d', $i));
        $user->setDni(26252 + $i);
        $user->setRoles(['ROLE_SUPRA']);

        //$user->setNombre($this->faker->firstName);
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'gus'
        ));
        $apiToken1 = new ApiToken($user);
        $apiToken2 = new ApiToken($user);
        $manager->persist($apiToken1);
        $manager->persist($apiToken2);
        $manager->persist($user);

        // $product = new Product();
        // $manager->persist($product);
        for ($i = 1; $i < 10; $i++) {

            $user = new Persona();
            $user->setEmail(sprintf('gust%d@gus.com', $i));
            $user->setNombre(sprintf('gust%d', $i));
            $user->setApellido(sprintf('gust%d', $i));
            $user->setDni(26252 + $i);
            $user->setRoles(['ROLE_ADMIN']);

            //$user->setNombre($this->faker->firstName);
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'gus'
            ));
            $apiToken1 = new ApiToken($user);
            $apiToken2 = new ApiToken($user);
            $manager->persist($apiToken1);
            $manager->persist($apiToken2);
            $manager->persist($user);

            if ($i == 9) {

                $buffy = new Buffy();
                $buffy->setName($comida[$i + 1]);

                $buffy->setStock($i + 21);
                $buffy->setPrecio($precio_[$i]);
                //$buffy->setNombre($this->faker->firstName);

                $manager->persist($buffy);

                $buffy2 = new Buffy();
                $buffy2->setName($comida[$i - 2]);

                $buffy2->setStock($i + 33);
                $buffy2->setPrecio($precio_[$i - 3]);
                //$buffy->setNombre($this->faker->firstName);

                //$manager->persist($buffy2);

                $pedido = new Pedido();

                $pedido->setCantidad($i + 1);
                $pedido->setRestaurant('A TU Medida');
                $pedido->addMenu($buffy);
                //$pedido->setMenu($buffy2);
                $pedido->setCreatedAt($pedido->getCreatedAt());
                $pedido->setUpdatedAt($pedido->getUpdatedAt());
                $pedido->setPersona($user);

                $manager->persist($pedido);

                $pedido1 = new Pedido();
                $pedido1->setCantidad($i);
                $pedido1->setRestaurant('A TU Medida');
                $pedido1->addMenu($buffy2);
                $pedido1->addMenu($buffy);
                $pedido1->addMenu($buffy);
                $pedido1->addMenu($buffy);
                $pedido1->addMenu($buffy);
                $pedido1->addMenu($buffy);
                //$pedido->setMenu($buffy2);
                $pedido1->setCreatedAt($pedido1->getCreatedAt());
                $pedido1->setUpdatedAt($pedido1->getUpdatedAt());
                $pedido1->setPersona($user);

                $manager->persist($pedido1);

                //$buffy2->addPedido($pedido);
                //$buffy2->addPedido($pedido1);

                $manager->persist($buffy2);

            }

        };

        for ($i = 10; $i < 20; $i++) {

            $user = new Persona();
            $user->setEmail(sprintf('gust%d@gus.com', $i));
            $user->setNombre(sprintf('gust%d', $i));
            $user->setApellido(sprintf('gust%d', $i));
            $user->setDni(26252 + $i);
            //$user->setRoles(['ROLE_ADMIN']);

            //$user->setNombre($this->faker->firstName);
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'gus'
            ));
            $apiToken1 = new ApiToken($user);
            $apiToken2 = new ApiToken($user);
            $manager->persist($apiToken1);
            $manager->persist($apiToken2);
            $manager->persist($user);

        };

/* for ($i = 0; $i < 20; $i++) {

$user->setEmail(sprintf('gus%d@gus.com', $i));
$user->setNombre(sprintf('gus%d', $i));
$user->setApellido(sprintf('gus%d', $i));
$user->setDni(26258210 + $i);
$user->setRoles(["ROLE_ADMIN"]);
//$user->setNombre($this->faker->firstName);
$user->setPassword($this->passwordEncoder->encodePassword(
$user,
'gus'
));
$manager->persist($user);
};

$manager->flush();*/
        $manager->flush();

    }
}
