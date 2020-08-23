<?php

namespace App\Controller;

use App\Entity\Buffy;
use App\Entity\Pedido;
use App\Form\PedidoType;
use App\Repository\BuffyRepository;
use App\Repository\PedidoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/pedido")
 */
class PedidoController extends AbstractController
{
    /**
     * @Route("/", name="pedido_index", methods={"GET"})
     */
    public function index(PedidoRepository $pedidoRepository): Response
    {
        return $this->render('pedido/index.html.twig', [
            'pedidos' => $pedidoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="pedido_new", methods={"GET","POST"})
     */
    function new (Request $request, PedidoRepository $pedidoRepository, BuffyRepository $buffyRepository): Response{
        $pedido = new Pedido();
        $form   = $this->createForm(PedidoType::class, $pedido);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $buffy = $form['menu']->getData();

            /*===================================================
            =            seccion vieja Vamos hacer
            Transanccioenes               =
            ===================================================*/
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($pedido);
            // $entityManager->flush();

            /*=====  End of seccion vieja Vamos    ======*/

            /*===================================
            =            transaccion            =
            ===================================*/

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->getConnection()->beginTransaction();

            try {
                // $form['menu']->getData();
                //numeroden
                //dd($buffy->getId());
                $stock1 = new Buffy();
                $stock1 = $buffyRepository->findBy(['id' => $buffy->getId()]);
                // $cuenta2 = $em->getRepository('VabadusBancoBundle:Cuenta')->find($id2);
                //dd($stock1[0]->getStock());
                //$form['cantidad']->getData() == 50)
                // $e = new Exception();
                //dd($stock1[0]->getStock() - $form['cantidad']->getData());

                $pedido->setPrecioPedido($stock1[0]->getPrecio() * $pedido->getCantidad());

                $stock1[0]->setStock($stock1[0]->getStock() - $form['cantidad']->getData());

                if ($stock1[0]->getStock() < 0) {
                    throw new Exception("Sin STOCK");
                }
                $entityManager->persist($stock1[0]);
                $entityManager->persist($pedido);

                $entityManager->flush();

                $entityManager->getConnection()->commit();

                return $this->redirectToRoute('pedido_index');

                // } else {
                //     $entityManager = $this->getEntityManager();
                //     $entityManager->remove($pedido);
                //     $entityManager->flush(); // save to the database
                // }

                // $cuenta1->setSaldo($cuenta1->getSaldo() - 1200);
                // $entityManager->persist($cuenta1);

                // $cuenta2->setSaldo($cuenta2->getSaldo() + 1200);

            } catch (Exception $e) {
                dump('aca');
                $entityManager->getConnection()->rollback();
                throw $e;
                //dd($e);
            } // finally {
            //     // code, it'll always be executed
            //     return $this->redirectToRoute('pedido_index');
            // }

            /* $entityManager->persist($pedido);
            $entityManager->flush();*/

            /*=====  End of transaccion  ======*/

            return $this->redirectToRoute('pedido_index');
        }

        return $this->render('pedido/new.html.twig', [
            'pedido' => $pedido,
            'form'   => $form->createView(),
        ]);
    }

/**
 * @Route("/{id}", name="pedido_show", methods={"GET"})
 */
    public function show(Pedido $pedido): Response
    {
        return $this->render('pedido/show.html.twig', [
            'pedido' => $pedido,
        ]);
    }

/**
 * @Route("/{id}/edit", name="pedido_edit", methods={"GET","POST"})
 */
    public function edit(Request $request, Pedido $pedido): Response
    {
        $form = $this->createForm(PedidoType::class, $pedido);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pedido_index');
        }

        return $this->render('pedido/edit.html.twig', [
            'pedido' => $pedido,
            'form'   => $form->createView(),
        ]);
    }

/**
 * @Route("/{id}", name="pedido_delete", methods={"DELETE"})
 */
    public function delete(Request $request, Pedido $pedido): Response
    {
        if ($this->isCsrfTokenValid('delete' . $pedido->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($pedido);
            $entityManager->flush();
        }

        return $this->redirectToRoute('pedido_index');
    }
}
