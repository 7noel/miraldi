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

if (! function_exists('formatearRazonSocialPeru')) {

    /**
     * Normaliza una razón social peruana:
     * - Detecta el tipo de empresa (texto largo y/o abreviado).
     * - Lo reemplaza por una abreviatura canónica (S.A.C., S.A., S.R.L., etc.).
     * - Evita duplicados y limpia espacios/guiones.
     *
     * @param  string  $nombre
     * @return string
     */
    function formatearRazonSocialPeru(string $nombre): string
    {
        if (trim($nombre) === '') {
            return '';
        }

        // === Normalizar espacios básicos ===
        $nombre = trim(preg_replace('/\s+/', ' ', $nombre));

        // === Pasar a MAYÚSCULAS con soporte UTF-8 ===
        if (function_exists('mb_strtoupper')) {
            $upper = mb_strtoupper($nombre, 'UTF-8');
        } else {
            $upper = strtoupper($nombre);
        }

        // === Lista de tipos de empresa más comunes en Perú ===
        // Puedes agregar más patrones sin problema.
        $tipos = [
            // Sociedad Anónima Cerrada
            [
                'abbr'     => 'S.A.C.',
                'patterns' => [
                    '/\bSOCIEDAD\s+AN(Ó|O)NIMA\s+CERRADA\b/u',
                    '/\bS\.?\s*A\.?\s*C\.?\b/u',
                ],
            ],

            // Sociedad Anónima Abierta
            [
                'abbr'     => 'S.A.A.',
                'patterns' => [
                    '/\bSOCIEDAD\s+AN(Ó|O)NIMA\s+ABIERTA\b/u',
                    '/\bS\.?\s*A\.?\s*A\.?\b/u',
                ],
            ],

            // Sociedad Anónima (genérica)
            [
                'abbr'     => 'S.A.',
                'patterns' => [
                    '/\bSOCIEDAD\s+AN(Ó|O)NIMA\b/u',
                    '/\bS\.?\s*A\.?(?!\s*C\.?|\.A\.)\b/u', // S.A. aislado
                ],
            ],

            // Sociedad de Responsabilidad Limitada
            [
                'abbr'     => 'S.R.L.',
                'patterns' => [
                    '/\bSOCIEDAD\s+DE\s+RESPONSABILIDAD\s+LIMITADA\b/u',
                    '/\bS\.?\s*R\.?\s*L\.?\b/u',
                ],
            ],

            // Sociedad Comercial de Responsabilidad Limitada
            [
                'abbr'     => 'S.C.R.L.',
                'patterns' => [
                    '/\bSOCIEDAD\s+COMERCIAL\s+DE\s+RESPONSABILIDAD\s+LIMITADA\b/u',
                    '/\bS\.?\s*C\.?\s*R\.?\s*L\.?\b/u',
                ],
            ],

            // Empresa Individual de Responsabilidad Limitada
            [
                'abbr'     => 'E.I.R.L.',
                'patterns' => [
                    '/\bEMPRESA\s+INDIVIDUAL\s+DE\s+RESPONSABILIDAD\s+LIMITADA\b/u',
                    '/\bE\.?\s*I\.?\s*R\.?\s*L\.?\b/u',
                ],
            ],

            // Sociedad Civil
            [
                'abbr'     => 'S. CIVIL',
                'patterns' => [
                    '/\bSOCIEDAD\s+CIVIL\b/u',
                    '/\bS\.?\s*CIVIL\b/u',
                ],
            ],

            // Sociedad Civil de Responsabilidad Limitada
            [
                'abbr'     => 'S. CIVIL DE R.L.',
                'patterns' => [
                    '/\bSOCIEDAD\s+CIVIL\s+DE\s+RESPONSABILIDAD\s+LIMITADA\b/u',
                    '/\bS\.?\s*CIVIL\s+DE\s+R\.?\s*L\.?\b/u',
                ],
            ],

            // Asociación
            [
                'abbr'     => 'ASOC.',
                'patterns' => [
                    '/\bASOCIACI(Ó|O)N\b/u',
                    '/\bASOC\.?\b/u',
                ],
            ],

            // Cooperativa
            [
                'abbr'     => 'COOP.',
                'patterns' => [
                    '/\bCOOPERATIVA\b/u',
                    '/\bCOOP\.?\b/u',
                ],
            ],

            // Fundación
            [
                'abbr'     => 'FUND.',
                'patterns' => [
                    '/\bFUNDACI(Ó|O)N\b/u',
                    '/\bFUND\.?\b/u',
                ],
            ],

        ];

        $tipoDetectado = null;
        $base = $upper;

        // Primero detectamos y a la vez vamos limpiando los textos/abreviaturas del tipo
        foreach ($tipos as $tipo) {
            foreach ($tipo['patterns'] as $pattern) {
                if (preg_match($pattern, $base)) {
                    // Guardamos el tipo solo la primera vez (para no sobreescribir si hay varios)
                    if ($tipoDetectado === null) {
                        $tipoDetectado = $tipo['abbr'];
                    }

                    // Eliminamos cualquier aparición del patrón del nombre base
                    $base = preg_replace($pattern, ' ', $base);
                }
            }
        }

        // Limpiar guiones y separadores sobras del final
        $base = preg_replace('/[\s\-,]+$/u', '', $base);
        // Limpiar espacios múltiples intermedios
        $base = preg_replace('/\s+/', ' ', $base);
        $base = trim($base);

        // Si no se detectó ningún tipo, devolvemos solo el nombre normalizado
        if ($tipoDetectado === null) {
            return $base;
        }

        // Si la base está vacía por alguna razón (todo era tipo), devolvemos solo la abreviatura
        if ($base === '') {
            return $tipoDetectado;
        }

        // Concatenar base + tipo en una sola forma canónica
        return $base . ' ' . $tipoDetectado;
    }
}

if (! function_exists('parsearRangosBultos')) {
    /**
     * Convierte "1-5,8,10" en [1,2,3,4,5,8,10] limitado a 1..$maxBultos
     */
    function parsearRangosBultos(?string $input, int $maxBultos): array
    {
        if (!$input) return [];

        $input   = str_replace(' ', '', $input);
        $partes  = explode(',', $input);
        $indices = [];

        foreach ($partes as $parte) {
            if ($parte === '') continue;

            if (strpos($parte, '-') !== false) {
                [$inicio, $fin] = explode('-', $parte, 2);
                $inicio = (int) $inicio;
                $fin    = (int) $fin;

                if ($inicio > 0 && $fin > 0 && $inicio <= $fin) {
                    for ($i = $inicio; $i <= $fin; $i++) {
                        if ($i >= 1 && $i <= $maxBultos) {
                            $indices[] = $i;
                        }
                    }
                }
            } else {
                $num = (int) $parte;
                if ($num >= 1 && $num <= $maxBultos) {
                    $indices[] = $num;
                }
            }
        }

        $indices = array_values(array_unique($indices));
        sort($indices);

        return $indices;
    }
}