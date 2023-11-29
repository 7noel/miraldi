<?php 
// require '../vendor/autoload.php';
use Luecano\NumeroALetras\NumeroALetras;

if (! function_exists('numero_letras')) {
    function numero_letras($number, $decimals, $currency_id) {
	    $formatter = new NumeroALetras();
		return $formatter->toInvoice($number, $decimals, config('options.table_sunat.moneda.'.$currency_id));
    }
}

if (! function_exists('getTipoCambio')) {
    function getTipoCambio($fecha)
    {
		$token = 'apis-token-1023.w5G1lEE2hQQ-mO6JwuSY3K812hvT0Ttl';
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api.apis.net.pe/v1/tipo-cambio-sunat?fecha=' . $fecha,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 2,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'GET',
		  CURLOPT_HTTPHEADER => array(
		    'Referer: https://apis.net.pe/tipo-de-cambio-sunat-api',
		    'Authorization: Bearer ' . $token
		  ),
		));
		$response = curl_exec($curl);
		curl_close($curl);

		return $tipoCambioSunat = json_decode($response);

    }
}

if (! function_exists('getTipoCambioMes')) {
	function getTipoCambioMes($y, $m)
	{
		$token = 'apis-token-1023.w5G1lEE2hQQ-mO6JwuSY3K812hvT0Ttl';
	   $ch = curl_init();
	   curl_setopt($ch, CURLOPT_URL, "https://api.apis.net.pe/v1/tipo-cambio-sunat?month=$m&year=$y");
	   curl_setopt(
	      $ch, CURLOPT_HTTPHEADER, array(
	       'Referer: https://apis.net.pe/tipo-de-cambio-sunat-api',
	       'Authorization: Bearer ' . $token
	      )
	   );
	   curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
	   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	   $respuesta  = curl_exec($ch);
	   curl_close($ch);
	   return json_decode($respuesta);
	}
}