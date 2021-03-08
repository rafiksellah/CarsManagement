<?php

namespace App\Controller;

use App\Entity\Depenses;
use App\Form\DepensesType;
use App\Repository\DepensesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dashboard/depenses")
 */
class DepensesController extends AbstractController
{
    /**
     * @Route("/", name="depenses_index", methods={"GET"})
     */
    public function index(DepensesRepository $depensesRepository): Response
    {
        return $this->render('depenses/index.html.twig', [
            'depenses' => $depensesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="depenses_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $depense = new Depenses();
        $form = $this->createForm(DepensesType::class, $depense);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($depense);
            $entityManager->flush();

            return $this->redirectToRoute('depenses_index');
        }

        return $this->render('depenses/new.html.twig', [
            'depense' => $depense,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="depenses_show", methods={"GET"})
     */
    public function show(Depenses $depense): Response
    {
        return $this->render('depenses/show.html.twig', [
            'depense' => $depense,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="depenses_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Depenses $depense): Response
    {
        $form = $this->createForm(DepensesType::class, $depense);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('depenses_index');
        }

        return $this->render('depenses/edit.html.twig', [
            'depense' => $depense,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="depenses_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Depenses $depense): Response
    {
        if ($this->isCsrfTokenValid('delete'.$depense->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($depense);
            $entityManager->flush();
        }

        return $this->redirectToRoute('depenses_index');
    }
}
