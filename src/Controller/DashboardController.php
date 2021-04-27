<?php

namespace App\Controller;

use App\Repository\DepensesRepository;
use App\Repository\LocationRepository;
use App\Repository\VehiculeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DashboardController extends AbstractController
{

    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboard(LocationRepository $locationRepository, DepensesRepository $depensesRepository, VehiculeRepository $vehiculeRepository): Response
    {
        $location_price = 0.00;
        $depense_price = 0.00;
        $vente_price = 0.00;
        $achat_price = 0.00;
        $vehicule_benefice = 0.00;
        $total_depenses = 0.00;
        $total_locations = 0.00;
        $total_chiffre_affaire = 0.00;
        $current_year = new \DateTime('now');
        $last_year = new \DateTime('last year');
        $years = [$last_year->format('Y'), $current_year->format('Y')];
        $years_color = [
            $last_year->format('Y') => 'red' , 
            $current_year->format('Y') => 'blue' 
        ];
        $park_color = [
            'Bastia' => 'red',
            'Marseille' => 'blue'
        ];
        $first_day_of_month = new \DateTime('first day of this month');
        $lastt_day_of_month = new \DateTime('last day of this month');

        foreach ($years as $year) {
            $total_locations_per_year[$year] = 0.00;
            $total_depenses_per_year[$year] = 0.00;
            $total_chiffre_affaire_per_year[$year] = 0.00;
            for ($m=1; $m<=12; $m++) {
                $month = date('m', mktime(0,0,0,$m, 1, date('Y')));
                $from = new \DateTime($year.'-'.$month.'-01');
                $to = new \DateTime(date($year.'-'.$month.'-t'));
                $locations = $locationRepository->findLocationsByInterval($from, $to);
                $depenses = $depensesRepository->findDepensesByInterval($from, $to);
                $vehiculeVendus = $vehiculeRepository->findVehiculeSoldByInterval($from, $to);
                $chiffre_affaire[$year][$month] = 0.00;
                $chiffre_affaire_per_park['Marseille'][$year][$month] = 0.00;
                $chiffre_affaire_per_park['Bastia'][$year][$month] = 0.00;
                $depenses_per_park['Marseille'][$year][$month] = 0.00;
                $depenses_per_park['Bastia'][$year][$month] = 0.00;
                foreach ($locations as $location) {
                    $chiffre_affaire_per_park[$location->getIdVehicule()->getParcStationnementVille()][$year][$month] += $location->getPrix();
                    $chiffre_affaire[$year][$month] += $location->getPrix();
                    $total_locations_per_year[$year] += $location->getPrix();
                }
                foreach ($depenses as $depense) {
                    if ($depense->getIdVehicule()) {
                        $depenses_per_park[$depense->getIdVehicule()->getParcStationnementVille()][$year][$month] += $depense->getPrix();
                    }
                    $total_depenses_per_year[$year] += $depense->getPrix();
                }
                foreach ($vehiculeVendus as $vehiculeVendu) {
                    $chiffre_affaire[$year][$month] += ($vehiculeVendu->getPrixVente() - $vehiculeVendu->getPrix());
                    $chiffre_affaire_per_park[$vehiculeVendu->getParcStationnementVille()][$year][$month] +=  ($vehiculeVendu->getPrixVente() - $vehiculeVendu->getPrix());
                }
            }
            $chiffre_affaire_json[$year] = json_encode(array_values($chiffre_affaire[$year]));
            $total_chiffre_affaire_per_year[$year] +=array_sum($chiffre_affaire[$year]);
        }
        foreach ($chiffre_affaire_per_park as $park => $chiffre_affaire_per_par) {
            foreach ($chiffre_affaire_per_par as $year => $chiffre_affaire_per_year_per_park) {
                foreach ($chiffre_affaire_per_year_per_park as $month => $chiffre) {
                    $benifice_per_park[$park][$year][$month] = $chiffre - $depenses_per_park[$park][$year][$month];
                } 
            }
        }

        $months_in_french = ['Janvier','Février','Mars','Avril','Mai','Juin','Juilet','Août','Septembre','Octobre','Novembre','Decembre'];
        $total_depenses = array_sum($total_depenses_per_year);
        $total_locations = array_sum($total_locations_per_year);
        $total_chiffre_affaire = array_sum($total_chiffre_affaire_per_year);

        $original_value = 1;
        if ($total_depenses_per_year[$last_year->format('Y')] != 0 ) {
            $original_value = $total_depenses_per_year[$last_year->format('Y')];
        }
        $percentage_increase_depense = (($total_depenses_per_year[$current_year->format('Y')] - $original_value)/$original_value)*100;

        $original_value = 1;
        if ($total_locations_per_year[$last_year->format('Y')] != 0 ) {
            $original_value = $total_locations_per_year[$last_year->format('Y')];
        }
        $percentage_increase_location = (($total_locations_per_year[$current_year->format('Y')] - $original_value)/$original_value)*100;
        
        $original_value = 1;
        if ($total_chiffre_affaire_per_year[$last_year->format('Y')] != 0 ) {
            $original_value = $total_chiffre_affaire_per_year[$last_year->format('Y')];
        }
        $percentage_increase_chiffre_affaire = (($total_chiffre_affaire_per_year[$current_year->format('Y')] - $original_value)/$original_value)*100;

        $locations = $locationRepository->findLocationsByInterval($first_day_of_month,$lastt_day_of_month);
        foreach ($locations as $location) {
            $location_price += $location->getPrix();
        }
        $depenses = $depensesRepository->findDepensesByInterval($first_day_of_month,$lastt_day_of_month);
        foreach ($depenses as $depense) {
            $depense_price += $depense->getPrix();
        }
        $vehiculeVendus = $vehiculeRepository->findVehiculeSoldByInterval($first_day_of_month,$lastt_day_of_month);
        foreach ($vehiculeVendus as $vehiculeVendu) {
            $vente_price += $vehiculeVendu->getPrixVente();
            $achat_price += $vehiculeVendu->getPrix();
        }
        $vehicule_benefice = ($vente_price + $location_price) - ($achat_price+$depense_price);
        $vente_vehicule = $vente_price - $achat_price;


        foreach ($depenses_per_park as $park => $depenses_per_par) {
            foreach ($depenses_per_par as $year => $depenses_per_pa) {
                $depenses_per_park[$park][$year] = array_values($depenses_per_pa);
            }
        }
        foreach ($chiffre_affaire_per_park as $chiffre_affaire_per_par) {
            foreach ($chiffre_affaire_per_par as $year => $chiffre_affaire_per_pa) {
                $chiffre_affaire_per_park[$park][$year] = array_values($chiffre_affaire_per_pa);
            }
        }
        foreach ($benifice_per_park as $benifice_per_par) {
            foreach ($benifice_per_par as $year => $benifice_per_) {
                $benifice_per_park[$park][$year] = array_values($benifice_per_);
            }
        }
        return $this->render('dashboard/index.html.twig', [
            'location_price' => $location_price,
            'depense_price' => $depense_price,
            'vehicule_benefice' => $vehicule_benefice,
            'vente_vehicule' => $vente_vehicule,
            'years' => $years,
            'years_color' => $years_color,
            'chiffre_affaire_json' => $chiffre_affaire_json,
            'months_in_french' => json_encode(array_values($months_in_french)),
            'total_chiffre_affaire' => $total_chiffre_affaire,
            'total_depenses' => $total_depenses,
            'total_locations' => $total_locations,
            'percentage_increase_depense' => $percentage_increase_depense,
            'percentage_increase_location' => $percentage_increase_location,
            'percentage_increase_chiffre_affaire' => $percentage_increase_chiffre_affaire,
            'depenses_per_park' => $depenses_per_park,
            'chiffre_affaire_per_park' => $chiffre_affaire_per_park,
            'benifice_per_park' => $benifice_per_park,
            'park_color' => $park_color,

        ]); 
    }

    /**
     * @Route("/", name="index")
     */
    public function index(UrlGeneratorInterface $urlGenerator): Response
    {
        return new RedirectResponse($urlGenerator->generate('dashboard'));
    }
}
