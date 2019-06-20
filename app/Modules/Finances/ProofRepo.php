<?php namespace App\Modules\Finances;

use App\Modules\Base\BaseRepo;
use App\Modules\Base\DocumentControlRepo;
use App\Modules\Finances\Proof;
use App\Modules\Sales\Order;
use App\Modules\Finances\ProofDetailRepo;
use App\Modules\Base\ExpenseRepo;
use App\Modules\Storage\MoveRepo;
use App\Modules\Storage\Stock;

class ProofRepo extends BaseRepo{

	public function getModel(){
		return new Proof;
	}

	public function filter($filter, $proof_type)
	{
		$q = Proof::where('my_company', session('my_company')->id)->where('proof_type', $proof_type);
		if ($filter->sn > 0) {
			return Proof::where('sn', $filter->sn)->get();
		} else {
			$q->where('created_at', '>=', $filter->f1)->where('created_at', '<=', $filter->f2.' 23:59:59');
			if(isset($filter->seller_id) && $filter->seller_id != '') {
				$q->where('seller_id', $filter->seller_id);
			}
			if(isset($filter->status_id) && $filter->status_id != '') {
				$q->where('status_id', $filter->status_id);
			}
			return $q->get();
		}
	}

	public function findWithAmortizations($id)
	{
		return Proof::where('id', $id)->with('amortizations.payment')->first();
	}
	public function index($filter = false, $search = false, $proof_type = 0)
	{
		if ($filter and $search) {
			return Proof::$filter($search)->with('company', 'document_type', 'payment_condition', 'currency')->where('proof_type', $proof_type)->orderBy("$filter", 'ASC')->paginate();
		} else {
			return Proof::orderBy('id', 'DESC')->with('company', 'document_type', 'payment_condition', 'currency')->where('proof_type', $proof_type)->paginate();
		}
	}

	public function save($data, $id=0)
	{
		$data = $this->prepareData($data);
		$model = parent::save($data, $id);
		if (isset($data['order_id'])) {
			$ot = Order::where('id', $data['order_id'])->update(['proof_id' => $model->id, 'invoiced_at' => date('Y-m-d H:i:s'), 'status' => config('options.order_status.3')]);
		}
		if (isset($data['control_id'])) {
			DocumentControlRepo::nextNumber($data['control_id']);
		}
		// Registra Movimientos
		if (isset($data['details'])) {
			$detailRepo = new ProofDetailRepo;
			$toDelete = $detailRepo->syncMany($data['details'], ['key' => 'proof_id', 'value' => $model->id], 'product_id');

			if (1==0) {
				$mov = new MoveRepo;
				$mov->destroy($toDelete);
				$mov->saveAll($model, 1);
			}
		}
		$this->saveExpenses($data, $model);
		if (isset($data['send_sunat']) and $data['send_sunat'] == 1 and $data['proof_type'] == 1) {
			$respuesta = $this->generarComprobante($model);
			$model->response_sunat = $respuesta;
			$model->save();
		}
		return $model;
	}

	public function getNextNumber($document_type_id, $my_company = 1)
	{
		$doc = DocumentControlRepo::getNextNumber($document_type_id, $my_company);
		$last = Proof::where('my_company', $my_company)->where('document_type_id', $document_type_id)->where('series', $doc->series)->orderBy('number', 'desc')->first();
		if ($last) {
			return ['id' => $doc->id, 'series' => $doc->series, 'number'=> ($last->number + 1)];
		} else {
			return ['id' => $doc->id, 'series' => $doc->series, 'number'=> 1];
		}
	}

	public function prepareData($data)
	{
		if ($data['my_company'] == '') {
			$data['my_company'] = session('my_company')->id;
		}
		if ($data['document_type_id'] == 3) {
			$data['mov'] = 0;
		} else {
			$data['mov'] = 1;
		}

		if ($data['is_import']) {
			$data['type_op'] = '18'; //2152
		} else {
			$data['type_op'] = '02'; //2136
		}

		if ($data['proof_type'] == 1 and $data['sn'] == '') {
			// $nextNumber = DocumentControlRepo::getNextNumber($data['document_type_id'], $data['my_company'], $data['reference_id']);
			//dd($nextNumber);
			$sn = $this->getNextNumber($data['document_type_id'], $data['my_company']);
			$data['series'] = $sn['series'];
			$data['number'] = $sn['number'];
			$data['sn'] = $sn['series'] . '-' . $sn['number'];
			$data['control_id'] = $sn['id'];
		}
		
		
		if (!isset($data['warehouse_id']) or $data['warehouse_id'] == '' or $data['warehouse_id'] == '0') {
			$data['warehouse_id'] = 1;
		}
		if (isset($data['expenses']) and $data['is_import'] != 1) {
			foreach ($data['expenses'] as $key => $exp) {
				$data['expenses'][$key]['is_deleted'] = 1;
			}
		}
		$gross_value = 0;
		$expenses = 0;
		$expenseCif = 0;
		if (isset($data['expenses'])) {
			foreach ($data['expenses'] as $key => $expense) {
				if ($key < 3) {
					$expenseCif += $expense['value'];
				}
				$expenses += $expense['value'];
				//$data['expenses'][$key]['currency_id'] = 2;
			}
		}
		//dd($data['expenses']);
		$gross_value = 0;
		$subtotal = 0;
		$d_items = 0;
		$total = 0;
		if (isset($data['details'])) {
			foreach ($data['details'] as $key => $detail) {
				if (isset($data['igv_code'])) {
					$data['details'][$key]['igv_code'] = $data['igv_code'];
				}
				if (!isset($detail['is_deleted'])) {
					$q = $detail['quantity'];
					$v = $detail['value'];
					$d1 = isset($detail['d1']) ? $detail['d1'] : 0 ;
					$d2 = isset($detail['d2']) ? $detail['d2'] : 0 ;
					$p = $v * (100 + config('options.tax.igv')) / 100;
					$vt = round( $v * $q * (100-$d1) * (100-$d2) / 100 )/100;
					$t = $q * round($vt/$q * (100 + config('options.tax.igv'))) /100;
					// dd($t);
					$discount = $v*$q - $vt;
					$data['details'][$key]['price'] = round($p, 2);
					$data['details'][$key]['discount'] = round($discount, 2);
					$data['details'][$key]['total'] = round($vt, 2);

					$d_items += $discount;
					$gross_value += $v * $q;
					$subtotal += round($vt, 2);
					$total += round($t, 2);

					// if (!isset($detail['discount'])) {
					// 	$detail['discount'] = 0;
					// }
					// $data['details'][$key]['total'] = round($detail['value']*$detail['quantity']*(100-$detail['discount']))/100;
					// $gross_value += $data['details'][$key]['total'];
				}
			}
		}
		$data['gross_value'] = $gross_value;
		$data['discount_items'] = $d_items;
		$data['subtotal'] = $gross_value + $expenseCif - $d_items;
		// $data['subtotal'] = $gross_value + $expenseCif;
		$data['total'] = $total;
		$data['tax'] = $data['total'] - $data['subtotal'];
		//cacular factor
		if ($data['proof_type'] == 2) {
			$factor = 1;
			if ($gross_value>0) {
				$factor = ($gross_value + $expenses) / $gross_value;
			}
			$data['factor'] = $factor;
			if (isset($data['details'])) {
				foreach ($data['details'] as $key => $detail) {
					if (!isset($detail['is_deleted'])) {
						$data['details'][$key]['cost'] = round(($detail['value']*$factor), 2);
					}
				}
			}
			if ($factor != 1) {
				$data['gross_value'] = $gross_value;
				$data['discount_items'] = $d_items;
				$data['subtotal'] = $gross_value + $expenseCif;
				$data['total'] = round($data['subtotal'] * (100 + config('options.tax.igv')) / 100, 2);
				$data['tax'] = $data['total'] - $data['subtotal'];
			}
		}

		// Obteniendo el stock_id
		if (isset($data['details'])) {
			foreach ($data['details'] as $key => $detail) {
				if (!isset($detail['stock_id']) and 1 == 1) {
					if (!isset($detail['warehouse_id'])) {
						$detail['warehouse_id'] = $data['warehouse_id'];
					}
					$s = Stock::firstOrCreate(['product_id' => $detail['product_id'], 'warehouse_id' => $detail['warehouse_id']]);
					$data['details'][$key]['stock_id'] = $s->id;
				}
			}
		}
		return $data;
	}

	/**
	 * guarda gastos de exportacion
	 * @param  [array] $expenses     [Data de los gastos]
	 * @param  [int] $model_id     [id de la importación]
	 * @param  [string] $expense_type [Modelo de la importación]
	 * @return [boolean]               [Retorna true al terminar de guardar]
	 */
	protected function saveExpenses($data, $model)
	{
		if (isset($data['expenses'])) {
			$expenseRepo = new ExpenseRepo;
			$expenseRepo->syncMany($data['expenses'], ['key' => 'expense_id', 'value' => $model->id], 'name', ['key'=>'expense_type', 'value' => $model->getMorphClass()]);
			return true;
		} else {
			return false;
		}
	}

	public function consultarCpe($model, $anulacion = 0)
	{
		$numero = explode('-', $model->number);
		$data = [
			"operacion" => ($anulacion == 0) ? "consultar_comprobante" : "consultar_anulacion",
			"tipo_de_comprobante" => $model->document_type->code,
			"serie" => $numero[0],
			"numero" => $numero[1]
		];
		$respuesta = $this->send($data);
		return $respuesta;

	}

	public function generarAnulacion($model)
	{
		$numero = explode('-', $model->number);
		$data = [
			"operacion" => "generar_anulacion",
			"tipo_de_comprobante" => $model->document_type->code,
			"serie" => $numero[0],
			"numero" => $numero[1],
			"motivo" => "ERROR DEL SISTEMA",
			"codigo_unico"=>""
		];
		$respuesta = $this->send($data);
		return $respuesta;
	}

	/**
	 * Genera Comprobante Electrónico
	 * @param  Proof $model Comprobante de Pago
	 * @return html        Retorna Respuesta
	 */
	public function generarComprobante($model)
	{
		$data = $this->prepareCpe($model);
		$respuesta = $this->send($data);
		return $respuesta; 
		//dd($respuesta);
		//$this->readRespuesta($respuesta);
	}

	/**
	 * Prepara el json a enviar a nubefact
	 * @param  Proof $model Comprobante de pago
	 * @return Array        array lista para ser formateada y enviada en formato json
	 */
	public function prepareCpe($model)
	{
		$data = array(
		    "operacion"				=> "generar_comprobante",
		    "tipo_de_comprobante"               => $model->document_type->code,
		    "serie"                             => $model->series,
		    "numero"				=> $model->number,
		    "sunat_transaction"			=> $model->sunat_transaction,
		    "cliente_tipo_de_documento"		=> $model->company->id_type->code,
		    "cliente_numero_de_documento"	=> $model->company->doc,
		    "cliente_denominacion"              => $model->company->company_name,
		    "cliente_direccion"                 => $model->company->address.' '. $model->company->ubigeo->distrito.'-'.$model->company->ubigeo->provincia.'-'.$model->company->ubigeo->departamento,
		    "cliente_email"                     => $model->email,
		    "cliente_email_1"                   => $model->email_1,
		    "cliente_email_2"                   => $model->email_2,
		    "fecha_de_emision"                  => date('d-m-Y'),
		    "fecha_de_vencimiento"              => "",
		    "moneda"                            => $model->currency->code,
		    "tipo_de_cambio"                    => "",
		    "porcentaje_de_igv"                 => "18.00",
		    "descuento_global"                  => "",
		    "descuento_global"                  => "",
		    "total_descuento"                   => "",
		    "total_anticipo"                    => "",
		    "total_gravada"                     => $model->subtotal,
		    "total_inafecta"                    => "",
		    "total_exonerada"                   => "",
		    "total_igv"                         => $model->tax,
		    "total_gratuita"                    => "",
		    "total_otros_cargos"                => "",
		    "total"                             => $model->total,
		    "percepcion_tipo"                   => "",
		    "percepcion_base_imponible"         => "",
		    "total_percepcion"                  => "",
		    "total_incluido_percepcion"         => "",
		    "detraccion"                        => "false",
		    "observaciones"                     => "",
		    "documento_que_se_modifica_tipo"    => "",
		    "documento_que_se_modifica_serie"   => "",
		    "documento_que_se_modifica_numero"  => "",
		    "tipo_de_nota_de_credito"           => "",
		    "tipo_de_nota_de_debito"            => "",
		    "enviar_automaticamente_a_la_sunat" => "true",
		    "enviar_automaticamente_al_cliente" => "true",
		    "codigo_unico"                      => "",
		    "condiciones_de_pago"               => "",
		    "medio_de_pago"                     => "",
		    "placa_vehiculo"                    => "",
		    "orden_compra_servicio"             => "",
		    "tabla_personalizada_codigo"        => "",
		    "formato_de_pdf"                    => "",
		);
		foreach ($model->details as $key => $detail) {
			$subtotal = $detail->quantity*$detail->value-$detail->discount;
			$total = round($subtotal*1.18, 2);
			$igv = $total - $subtotal;
			$data['items'][] = array(
				"unidad_de_medida"          => 'NIU',
				// "unidad_de_medida"          => $detail->product->unit->code,
				"codigo"                    => $detail->product->intern_code,
				"descripcion"               => $detail->product->name,
				"cantidad"                  => $detail->quantity,
				"valor_unitario"            => $detail->value,
				"precio_unitario"           => $detail->price,
				"descuento"                 => $detail->discount,
				"subtotal"                  => $subtotal,
				"tipo_de_igv"               => $detail->igv_code,
				"igv"                       => $igv,
				"total"                     => $total,
				"anticipo_regularizacion"   => "false",
				"anticipo_documento_serie"  => "",
				"anticipo_documento_numero" => ""
			);
		}
		//dd($data);
		return $data;
		
	}

	/**
	 * Envía data json a nubefact
	 * @param  Array $data data lista para ser enviada
	 * @return Json            Respuesta de Nubefact
	 */
	public function send($data)
	{
		$data_json = json_encode($data);
		// RUTA para enviar documentos
		$ruta = "https://api.nubefact.com/api/v1/8e91b7c2-437a-41b8-b8f3-3b17dceb7c7d";

		//TOKEN para enviar documentos
		$token = "dce7ee606a1c4164ac289ff95405e27bbf5f60418957425c8ffe916e95aea464";

		//Invocamos el servicio de NUBEFACT
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $ruta);
		curl_setopt(
			$ch, CURLOPT_HTTPHEADER, array(
			'Authorization: Token token="'.$token.'"',
			'Content-Type: application/json',
			)
		);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$respuesta  = curl_exec($ch);
		curl_close($ch);

		return $respuesta;
	}

	/**
	 * Leer Respuesta
	 * @param  Json $respuesta respuesta de nubefact
	 * @return html            Imprime en pantalla la respuesta
	 */
	public function readRespuesta($respuesta)
	{
		$leer_respuesta = json_decode($respuesta, true);
		if (isset($leer_respuesta['errors'])) {
			//Mostramos los errores si los hay
		    echo $leer_respuesta['errors'];
		} else {
			//Mostramos la respuesta
		?>
		<h2>RESPUESTA DE SUNAT</h2>
		    <table border="1" style="border-collapse: collapse">
		        <tbody>
		            <tr><th>tipo:</th><td><?php echo $leer_respuesta['tipo_de_comprobante']; ?></td></tr>
		            <tr><th>serie:</th><td><?php echo $leer_respuesta['serie']; ?></td></tr>
		            <tr><th>numero:</th><td><?php echo $leer_respuesta['numero']; ?></td></tr>
		            <tr><th>enlace:</th><td><?php echo $leer_respuesta['enlace']; ?></td></tr>
		            <tr><th>aceptada_por_sunat:</th><td><?php echo $leer_respuesta['aceptada_por_sunat']; ?></td></tr>
		            <tr><th>sunat_description:</th><td><?php echo $leer_respuesta['sunat_description']; ?></td></tr>
		            <tr><th>sunat_note:</th><td><?php echo $leer_respuesta['sunat_note']; ?></td></tr>
		            <tr><th>sunat_responsecode:</th><td><?php echo $leer_respuesta['sunat_responsecode']; ?></td></tr>
		            <tr><th>sunat_soap_error:</th><td><?php echo $leer_respuesta['sunat_soap_error']; ?></td></tr>
		            <tr><th>pdf_zip_base64:</th><td><?php echo $leer_respuesta['pdf_zip_base64']; ?></td></tr>
		            <tr><th>xml_zip_base64:</th><td><?php echo $leer_respuesta['xml_zip_base64']; ?></td></tr>
		            <tr><th>cdr_zip_base64:</th><td><?php echo $leer_respuesta['cdr_zip_base64']; ?></td></tr>
		            <tr><th>codigo_hash:</th><td><?php echo $leer_respuesta['cadena_para_codigo_qr']; ?></td></tr>
		            <tr><th>codigo_hash:</th><td><?php echo $leer_respuesta['codigo_hash']; ?></td></tr>
		        </tbody>
		    </table>
		<?php
		}
	}

	public function autocomplete1($term, $company_id)
	{
		return Proof::where('sn','like',"%$term%")->where('company_id', $company_id)->where('status_id', 0)->where('payment_condition_id', 3)->whereIn('proof_type', [1, 3])->with('document_type', 'currency')->get();
	}

	public function autocomplete2($term, $company_id)
	{
		return Proof::where('sn','like',"%$term%")->where('company_id', $company_id)->where('status_id', 0)->where('payment_condition_id', 3)->whereIn('proof_type', [2, 4])->with('document_type', 'currency')->get();
	}

}