<?php

namespace App\Controller;

use App\Service\ApiHelper;
use App\Entity\Location;
use App\Form\LocationType;
use App\Repository\LocationRepository;
use App\Repository\VehiculeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dashboard/location")
 */
class LocationController extends AbstractController
{
    /**
     * @Route("/", name="location_index", methods={"GET"})
     */
    public function index(LocationRepository $locationRepository): Response
    {
        return $this->render('location/index.html.twig', [
            'locations' => $locationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/import", name="location_import")
     */
    public function import(Request $request, LocationRepository $locationRepository, VehiculeRepository $vehiculeRepository): Response
    {   
        $locations = array();
        $entityManager = $this->getDoctrine()->getManager();
        $imported_locations = $request->request->get('location');
        if ($imported_locations) {
            foreach ($imported_locations as $key => $imported_location) {
                $vehicule =  $vehiculeRepository->findOneBy(['immatriculation' => $imported_location['immatriculation']]);
                $new_location = new Location();
                $new_location->setIdVehicule($vehicule);
                $new_location->setPlateformeLocation($imported_location['plateformeLocation']);
                $new_location->setParcStationnement($imported_location['parcStationnementVille']);
                $new_location->setDateDebut(new \DateTime($imported_location['start_date']));
                $new_location->setDateFin(new \DateTime($imported_location['end_date']));
                $new_location->setRemarque($imported_location['remarque']);
                $new_location->setPrix($imported_location['price']);
                $new_location->setIdLocationGetaround($imported_location['id']);
                $entityManager->persist($new_location);
                $entityManager->flush();
            }
            return $this->redirectToRoute('location_index');
        }

        $month = $request->query->get('month');
        if ($month) {
            $apiHelper = new ApiHelper();
            $locations_api = $apiHelper->getLocations($month);
            foreach ($locations_api as $key => $location) {
                $existed_location = $locationRepository->findOneBy(['idLocationGetaround' => $location['id']]);
                if (!$existed_location) {
                    $vehicule =  $vehiculeRepository->findOneBy(['immatriculation' => $location['immatriculation']]);
                    if ($vehicule) {
                        $locations[$key] = $location;
                        $locations[$key]['plateformeLocation'] = 'Getaround';
                        $locations[$key]['parcStationnementVille'] = $vehicule->getParcStationnementVille();
                        $locations[$key]['model'] = $vehicule->getModel() .' '.$vehicule->getMark();
                    }
                }
            }
        }
        return $this->render('location/import.html.twig', [
            'locations' => $locations,
        ]);
    }


    /**
     * @Route("/new", name="location_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $location = new Location();
        $form = $this->createForm(LocationType::class, $location);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($location);
            $entityManager->flush();

            return $this->redirectToRoute('location_index');
        }

        return $this->render('location/new.html.twig', [
            'location' => $location,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="location_show", methods={"GET"})
     */
    public function show(Location $location): Response
    {
        return $this->render('location/show.html.twig', [
            'location' => $location,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="location_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Location $location): Response
    {
        $form = $this->createForm(LocationType::class, $location);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('location_index');
        }

        return $this->render('location/edit.html.twig', [
            'location' => $location,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="location_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Location $location): Response
    {
        if ($this->isCsrfTokenValid('delete'.$location->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($location);
            $entityManager->flush();
        }

        return $this->redirectToRoute('location_index');
    }

}
