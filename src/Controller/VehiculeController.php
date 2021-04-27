<?php

namespace App\Controller;

use App\Entity\Vehicule;
use App\Form\VehiculeType;
use App\Repository\VehiculeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ApiHelper;

/**
 * @Route("/dashboard/vehicule")
 */
class VehiculeController extends AbstractController
{
    /**
     * @Route("/", name="vehicule_index", methods={"GET"})
     */
    public function index(VehiculeRepository $vehiculeRepository, Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $apiHelper = new ApiHelper();
        $unavailable_cars = $apiHelper->getVehiculeUnavailability();
        $filer_city = '';
        $vehicules = $vehiculeRepository->findAll();
        foreach ($vehicules as $vehicule) {
            $id_cars_getaround = $vehicule->getIdVehiculeGetaround();
            if ($vehicule->getStatus() != 2 ) {
                if (in_array($id_cars_getaround, $unavailable_cars) ) {
                    $vehicule->setStatus(1);
                    $entityManager->flush();
                }
            }
        }
        $ville = $request->query->get('city');
        if ($ville) {
            $vehicules = $vehiculeRepository->findBy(['parcStationnementVille' => $ville]);
            $filer_city = $ville;
        }else{
            $vehicules = $vehiculeRepository->findAll();
        }

        return $this->render('vehicule/index.html.twig', [
            'vehicules' => $vehicules,
            'filer_city' => $filer_city,
        ]);
    }

    /**
     * @Route("/sellvehicule", name="sellvehicule")
     */
    public function sellvehicule(Request $request, VehiculeRepository $vehiculeRepository): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $idvehicule = $request->query->get('idvehicule');
        $prixvente = $request->query->get('prixvente');
        $vehicule = $vehiculeRepository->find($idvehicule);
        $vehicule->setStatus(2);
        $vehicule->setPrixVente($prixvente);
        $entityManager->flush();
        return $this->redirectToRoute('vehicule_index');
    }


    // /**
    //  * @Route("/refresh", name="refresh_avail_vehicule")
    //  */
    // public function refresh(Request $request, VehiculeRepository $vehiculeRepository): Response
    // {
    //     $entityManager = $this->getDoctrine()->getManager();
    //     $apiHelper = new ApiHelper();
    //     $unavailable_cars = $apiHelper->getVehiculeUnavailability();
    //     $vehicules = $vehiculeRepository->findAll();
    //     foreach ($vehicules as $vehicule) {
    //         $id_cars_getaround = $vehicule->getIdVehiculeGetaround();
    //         if ($vehicule->getStatus() != 2 ) {
    //             if (in_array($id_cars_getaround, $unavailable_cars) ) {
    //                 $vehicule->setStatus(1);
    //                 $entityManager->flush();
    //             }
    //         }
    //     }
    //     return $this->redirectToRoute('vehicule_index');
    // }

    /**
     * @Route("/new", name="vehicule_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $vehicule = new Vehicule();
        $form = $this->createForm(VehiculeType::class, $vehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vehicule->setStatus(0);
            $vehicule->setPrixVente(0);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($vehicule);
            $entityManager->flush();

            return $this->redirectToRoute('vehicule_index');
        }

        return $this->render('vehicule/new.html.twig', [
            'vehicule' => $vehicule,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="vehicule_show", methods={"GET"})
     */
    public function show(Vehicule $vehicule): Response
    {
        $location_price = 0.00;
        $depense_price = 0.00;
        $vehicule_benefice = 0.00;
        foreach ($vehicule->getLocations() as $location) {
            $location_price += $location->getPrix();
        }
        foreach ($vehicule->getDepenses() as $depense) {
            $depense_price += $depense->getPrix();
        }
        $vehicule_benefice = ($location_price + $vehicule->getPrixVente()) - $depense_price; 
        if ($vehicule->getStatus() == 2) {
            $vehicule_benefice = $vehicule_benefice - $vehicule->getPrix();
        }
        return $this->render('vehicule/show.html.twig', [
            'vehicule' => $vehicule,
            'location_price' => $location_price,
            'depense_price' => $depense_price,
            'vehicule_benefice' => $vehicule_benefice,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="vehicule_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Vehicule $vehicule): Response
    {
        $form = $this->createForm(VehiculeType::class, $vehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vehicule_index');
        }

        return $this->render('vehicule/edit.html.twig', [
            'vehicule' => $vehicule,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="vehicule_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Vehicule $vehicule): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vehicule->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($vehicule);
            $entityManager->flush();
        }

        return $this->redirectToRoute('vehicule_index');
    }
}
