<?php

namespace App\Service;

class ApiHelper
{
	public $invoice_ids = array();

    public function apiConnexion($url)
    {
		$curl=curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
		    'Authorization: Bearer '.$_SERVER['BEARER_TOKEN'],
		    'Accept: application/vnd.api+json',
		    'Content-Type: application/vnd.api+json'
		));
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_TIMEOUT, 120);
		curl_setopt($curl, CURLOPT_ENCODING, '');

		$response = curl_exec($curl);
		$http_code = curl_getinfo($curl);
		curl_close($curl);

		if ($http_code['http_code'] == 200) {
			return json_decode($response, true);
		}
		else{
			return 'error';
		}
    }
    public function getInvoiceIds($invoices)
    {
		foreach ($invoices['data'] as $invoice) {
			$this->invoice_ids[] = $invoice['id'];
		}
		if ($invoices['links']['next'] != NULL ) {
			$new_invoices = $this->apiConnexion($invoices['links']['next']);
			$this->getInvoiceIds($new_invoices);
		}else{
			return $this->invoice_ids;
		}
    }

    public function getInvoiceDetails($invoice_ids)
    {
    	$invoices_with_details = array();
    	foreach ($invoice_ids as $invoice_id) {
			$url = "https://api-eu.getaround.com/api/partners/v1/invoices/".$invoice_id.".json";
			$invoice_detail = $this->apiConnexion($url);
			if ($invoice_detail != 'error') {
				$invoices_with_details[$invoice_id]['id'] = $invoice_id;
				$invoices_with_details[$invoice_id]['immatriculation'] = $invoice_detail['data']['attributes']['car_plate_number'];
				$invoices_with_details[$invoice_id]['start_date'] = new \DateTime($invoice_detail['data']['attributes']['trip_start_date_and_time']);;
				$invoices_with_details[$invoice_id]['end_date'] =  new \DateTime($invoice_detail['data']['attributes']['trip_end_date_and_time']);;
				$invoices_with_details[$invoice_id]['price'] = round(abs($invoice_detail['data']['attributes']['total_price'] / 100), 2);
			}
    	}
    	return $invoices_with_details;
    }

    public function getLocations($month)
    {
    	$invoices_with_details = array();
		$months = ['00','01','02','03','04','05','06','07','08','09','10','11','12'];
		if ($month != "") {
			$months = [ $month ];
		}
		foreach ($months as $month) {
			if ($month <= date('n')) {
			if ($month == '00') {
	        	$date_from = new \DateTime(date('2020-12-01'));
			}else{
	        	$date_from = new \DateTime(date('Y-'.$month.'-01'));
			}
	        $from = $date_from->format('Y-m-d\TH:i:s\Z');
	        if ($month == date('n')) {
	        	$date_to = new \DateTime('now');
	        }else{
	        	if ($month == '00') {
	        		$date_to = new \DateTime(date('2020-12-31 H:i' , strtotime(date('2020-12-31') .' +23hours +59minute')));
	        	}else{
	        		$date_to = new \DateTime(date('Y-'.$month.'-t H:i' , strtotime(date('Y-'.$month.'-t') .' +23hours +59minute')));
	        	}
	        }
	        $to = $date_to->format('Y-m-d\TH:i:s\Z');
	        $url = "https://api-eu.getaround.com/api/partners/v1/invoices?end_date=".$to."&start_date=".$from;
			$invoices = $this->apiConnexion($url);
			if (isset($invoices['data'])) {
				$invoice_ids = $this->getInvoiceIds($invoices);
				if (!empty($invoice_ids)) {
					$invoices_with_details = $this->getInvoiceDetails($invoice_ids);
				}
			}
			}
		}
    	return $invoices_with_details;
    }

    public function getVehiculeUnavailability($dateFrom = null, $dateTo = null)
    {
		if (!$dateFrom || !$dateTo) {
			$dateFrom = new \DateTime('today');
			$dateTo = new \DateTime('tomorrow');
		}
		$from = $dateFrom->format('Y-m-d\TH:i:s\Z');
		$to = $dateTo->format('Y-m-d\TH:i:s\Z');
		$url = "https://api-eu.getaround.com/api/partners/v1/unavailabilities.json?end_date=".$to."&start_date=".$from;
		$unavailabilities = $this->apiConnexion($url);
		$car_ids = [];
		if ($unavailabilities != 'error') {
			foreach ($unavailabilities['data'] as $unavailability) {
				$car_ids[] = $unavailability['attributes']['car_id'];
			}
		}
		return $car_ids;
    }


	public function getAllVehiculeUnavailabilityPerMonth($year){
		$months = ['January','February','March','april','May','June','July ','August','September','October','November','December'];
		$car_unavailability=[];
        for ($i=0; $i <count($months) ; $i++) {
            $from=new \DateTime('first day of '.$months[$i].' '.$year);
            $to = new \DateTime('last day of '. $months[$i].' '.$year.' midnight');
            $allUnavailabilities = $this->getUnavailabilities($from, $to);
            foreach ($allUnavailabilities['data'] as $allUnavalability) {
				$carId=$allUnavalability['attributes']['car_id'];
				$dayEnd= new \DateTime($allUnavalability['attributes']['ends_at']);
				$dayStart= new \DateTime($allUnavalability['attributes']['starts_at']);
				if (!isset($car_unavailability[$i+1][$carId]['number_days'])) {
					$car_unavailability[$i+1][$carId]['number_days'] = 0;
				}
				if (!isset($car_unavailability[$i+1][$carId]['percent_days'])) {
					$car_unavailability[$i+1][$carId]['percent_days'] = 0;
				}
				$days = $dayEnd->diff($dayStart)->days+1;
				$number_days_in_month = cal_days_in_month(CAL_GREGORIAN, $from->format('n'), $from->format('Y'));
				$days_before = $dayStart->diff($from)->days;
				$days_after = $to->diff($dayEnd)->days;
				if ($dayStart->diff($from)->invert == 0 && $days_before) {
					$days -= $days_before;
				}
				if ($to->diff($dayEnd)->invert == 0 && $days_after) {
					$days -= $days_after;
				}
				if ($days >= $number_days_in_month) {
					$car_unavailability[$i+1][$carId]['number_days'] = $number_days_in_month;
					$car_unavailability[$i+1][$carId]['percent_days'] = 100;
				}else{
					$car_unavailability[$i+1][$carId]['number_days'] += $days;
					$car_unavailability[$i+1][$carId]['percent_days'] += ceil(($days * 100)/$number_days_in_month);
				}
            }
        }
		return $car_unavailability;
	}

	public function getUnavailabilities($dateFrom, $dateTo){
		$from = $dateFrom->format('Y-m-d\TH:i:s\Z');
		$to = $dateTo->format('Y-m-d\TH:i:s\Z');
		$url = "https://api-eu.getaround.com/api/partners/v1/unavailabilities.json?end_date=".$to."&start_date=".$from;
		$unavailabilities = $this->apiConnexion($url);
		return $unavailabilities;
	}



}
