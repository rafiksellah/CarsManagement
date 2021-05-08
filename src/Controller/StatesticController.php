<?php

namespace App\Controller;

use App\Repository\DepensesRepository;
use App\Repository\LocationRepository;
use App\Repository\VehiculeRepository;
use App\Service\ApiHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatesticController extends AbstractController
{
    /**
     * @Route("/dashboard/statestic", name="statestic")
     */
    public function index(Request $request, LocationRepository $locationRepository, DepensesRepository $depensesRepository, VehiculeRepository $vehiculeRepository, ApiHelper $apiHelper): Response
    {
        $year = $request->query->get('year');
        $total_achat = 0.00;
        $total_vente = 0.00;
        $total_depense = 0.00;
        $total_location = 0.00;
        $by_vehicule = [];
        if ($year) {
            $from = new \DateTime('first day of january'. $year);
            $to = new \DateTime('last day of december'. $year);
            $locations = $locationRepository->findLocationsByInterval($from, $to);
            $depenses = $depensesRepository->findDepensesByInterval($from, $to);
            $vehiculesVendus = $vehiculeRepository->findVehiculeSoldByInterval($from, $to);
            $vehiculesAchetes = $vehiculeRepository->findVehiculesAchatByInterval($from, $to);
            $vehiculesActiveCount = $vehiculeRepository->findVehiculesActiveCountByInterval($from, $to);
        }else{
            $year = '2021';
            $from = new \DateTime('first day of january 2020');
            $to = new \DateTime('now');
            $locations = $locationRepository->findLocationsByInterval($from, $to);
            $depenses = $depensesRepository->findDepensesByInterval($from, $to);
            $vehiculesVendus = $vehiculeRepository->findVehiculeSoldByInterval($from, $to);
            $vehiculesAchetes = $vehiculeRepository->findVehiculesAchatByInterval($from, $to);
            $vehiculesActiveCount = $vehiculeRepository->findVehiculesActiveCountByInterval($from, $to);
        }

        foreach ($locations as $location) {
            $by_vehicule[$location->getIdVehicule()->getId()]['locations'][] = $location->getPrix(); 
            $total_location += $location->getPrix();
        }
        foreach ($depenses as $depense) {
            if ($depense->getIdVehicule()) {
                $by_vehicule[$depense->getIdVehicule()->getId()]['depenses'][] = $depense->getPrix(); 
            }
            $total_depense += $depense->getPrix();
        }
        foreach ($vehiculesVendus as $vehiculesVendu) {
            $by_vehicule[$vehiculesVendu->getId()]['prix_vente'] = $vehiculesVendu->getPrix(); 
            $total_vente += $vehiculesVendu->getPrixVente();
        }
        foreach ($vehiculesAchetes as $vehiculesAchete) {
            $by_vehicule[$vehiculesAchete->getId()]['prix_achat'] = $vehiculesAchete->getPrix(); 
            $total_achat += $vehiculesAchete->getPrix();
        }
        $all_vehicules = $vehiculeRepository->findAll();

        $allUnavailabilities = $apiHelper->getAllVehiculeUnavailabilityPerMonth($year);

        //dd($allUnavailabilities);

        return $this->render('statestic/index.html.twig', [
            'total_location' => $total_location,
            'total_depense' => $total_depense,
            'total_vente' => $total_vente,
            'total_achat' => $total_achat,
            'by_vehicule' => $by_vehicule,
            'all_vehicules' => $all_vehicules,
            'vehiculesActiveCount' => $vehiculesActiveCount,
            'vehiculeVenduCount' => count($vehiculesVendus),
        ]);
    }
}
