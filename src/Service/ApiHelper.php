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
		$months = ['01','02','03','04','05','06','07','08','09','10','11','12'];
		if ($month != "") {
			$months = [ $month ];
		}
		foreach ($months as $month) {
			if ($month <= date('n')) {
	        $date_from = new \DateTime(date('Y-'.$month.'-01'));
	        $from = $date_from->format('Y-m-d\TH:i:s\Z');
	        if ($month == date('n')) {
	        	$date_to = new \DateTime('now');
	        }else{
	        	$date_to = new \DateTime(date('Y-'.$month.'-t H:i' , strtotime(date('Y-'.$month.'-t') .' +23hours +59minute')));
	        }
	        $to = $date_to->format('Y-m-d\TH:i:s\Z');
	        $url = "https://api-eu.getaround.com/api/partners/v1/invoices?end_date=".$to."&start_date=".$from;
			$invoices = $this->apiConnexion($url);
			$invoice_ids = $this->getInvoiceIds($invoices);
			if (!empty($invoice_ids)) {
				$invoices_with_details = $this->getInvoiceDetails($invoice_ids);
			}
			}
		}
    	return $invoices_with_details;
    }
}
