<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Cotización {{ $model->id }}-{{ $model->created_at->formatLocalized('%Y') }}</title>
	<link rel="stylesheet" href="./css/print_pdf.css">
</head>
<body>
	<script type="text/php">
	if (isset($pdf)) {
		$x = 540;
        $y = 765;
        $text = "Pág. {PAGE_NUM} de {PAGE_COUNT}";
        $font = null;
        $size = 8;
        $color = array(0, 0, 0);
        $word_space = 0.0;  //  default
        $char_space = 0.0;  //  default
        $angle = 0.0;   //  default
        $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
	}
	</script>
	<header class="">
		<div class="header1">
			<img src="./img/logo.png" alt="" width="180px">
		</div>
		<div class="header2">
			<div class="ruc">RUC: 20600096622</div>
		</div>
	</header>
	<footer>
		<div class="center">Av. Alfredo Benavides Nº1555 - Oficina 306 - Miraflores, Lima - Perú</div>
		<div class="center"><strong>T:</strong> (511) 6833-0884 <strong>E:</strong> contactenos@ddmmedical.com <strong>W:</strong> www.ddmmedical.com</div>
	</footer>
	<div>
		<table class="table-items">
			<tbody>
				<tr>
					<td width="60%" class="" valign="bottom">
						<p></p>
						<p>Sres.:</p>
						<div>{{ $model->company->company_name }}</div>
						@if(trim($model->attention)!="")
						<div>Atención: {{ $model->attention }}</div>
						@endif
						<p>Presente.-</p>
						@if(trim($model->matter)!="")
						<div>Asunto:</div>
						@endif
					</td>
					<td class="">
						<p></p>
						<div><strong>Cotización: {{ str_pad($model->id, 3, '0', STR_PAD_LEFT) }} - {{ $model->created_at->formatLocalized('%Y') }}</strong></div>
						<div>Tel.</div>
						<div>+51-1-683-0884</div>
						<div>Cel.</div>
						<div>+51-983509797</div>
						<div>E-mail</div>
						<div>jchu@ddmmedical.com</div>
						<p align="right">Lima, {{ $model->created_at->formatLocalized('%A %d de %B de %Y') }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="asunto">
		@if(trim($model->matter)!="")
		<p>{{ $model->matter }}</p>
		@endif
		<p>Estimados Sras. /Sres.</p>
		<p>Tomando como referencia su solicitud arriba mencionada, le adjuntamos la correspondiente oferta. Contiene una descripcion de los productos solicitados. Si tiene alguna consulta, por favor no dude en contactarnos.</p>
	</div>
	<div class="container-items">
		<table class="table-items">
			<thead>
				<tr>
					<th class="th1 border center">ITEM</th>
					<th class="th2 border center">DESCRIPCION DEL PRODUCTO</th>
					<th class="th3 border center">UND</th>
					<th class="th4 border center">P. UNIT.</th>
					<th class="th5 border center">TOTAL</th>
				</tr>
			</thead>
			<tbody>
				@foreach($model->details as $key => $detail)
				<tr>
					<td class="border center">{{ $key + 1 }}</td>
					<td class="border">
						<div><strong>{{ $detail->product->name }}</strong></div>
						@if(trim($detail->product->model)!="")
						<div><strong>MODELO: {{ $detail->product->model }}</strong></div>
						@endif
						@if(isset($detail->product->brand))
						<div><strong>MARCA: {{ $detail->product->brand->name }}</strong></div>
						@endif
						@if(isset($detail->product->country))
						<div><strong>PROCEDENCIA: {{ $detail->product->country->description }}</strong></div>
						@endif
						<div>
							{!! nl2br($detail->product->description) !!}
						</div>
					</td>
					<td class="border center">{{ $detail->quantity }}</td>
					<td class="border center">{{ $detail->price }}</td>
					<td class="border center">{{ $detail->total }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		<table class="table-total">
			<tbody>
				<tr>
					<td class="th1"></td>
					<td class="th2"></td>
					<td class="th3"></td>
					<td class="th4 border right">SubTot.:</td>
					<td class="th5 border center">{{ $model->subtotal }}</td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td class="border right">IGV:</td>
					<td class="border center">{{ $model->tax }}</td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td class="border right">Total:</td>
					<td class="border center">{{ $model->total }}</td>
				</tr>
			</tbody>
		</table>

	</div>
	@if(trim($model->comment)!="")
	<p><strong>Comentario:</strong> {{$model->comment}}</p>
	@endif
	<div class="condiciones">
		<p><strong><em><u>CONDICIONES DE PAGO</u></em></strong></p>
		<table class="pmargin-condition">
			<tr>
				<td>Forma de Pago:</td>
				<td>{{ $model->payment_condition->name }}</td>
			</tr>
			@foreach(config('options.bank_accounts') as $key => $account)
			<tr>
				<td>{{ $account['label'] }}:</td>
				<td>{{ $account['number'] }} <strong>CCI</strong> {{ $account['cci'] }}</td>
			</tr>
			@endforeach
			<tr>
				<td>Validéz de la oferta:</td>
				<td>30 días</td>
			</tr>
		</table>
		<p><strong><em><u>CONDICIONES COMERCIALES</u></em></strong></p>
		<table class="pmargin-condition">
			<tr>
				<td>Plazo de Entrega:</td>
				<td>{{ $model->delivery_period }}</td>
			</tr>
			<tr>
				<td>Lugar de Entrega:</td>
				<td>{{ $model->delivery_place }}</td>
			</tr>
			@if( trim($model->installation_period)!='' )
			<tr>
				<td>Plazo de Instalación:</td>
				<td>{{ $model->installation_period }}</td>
			</tr>
			@endif
		</table>
		@if( trim($model->offer_period)!='' )
		<p><strong><em><u>CONDICIONES DE GARANTÍA</u></em></strong></p>
		<table class="pmargin-condition">
			<tr>
				<td>Plazo Ofertado:</td>
				<td>{{ $model->offer_period }}</td>
			</tr>
			<tr>
				<td> </td>
				<td> </td>
			</tr>
			<tr>
				<td><strong>Elaborado por: </strong></td>
				<td><strong>{{ $model->audits->first()->user->name }}</strong></td>
			</tr>
		</table>
		@endif
		<table>
			<tr>
				<td><strong>Elaborado por: </strong></td>
				<td><strong>{{ $model->audits->first()->user->name }}</strong></td>
			</tr>
		</table>
		
	</div>
	<p>Les saluda atentamente</p>
	<div class="firma">
		<div>{{ $model->seller->full_name }}</div>
		<div>Proyectos y Licitaciones</div>
		<div>Teléfono: +51-1-6830884</div>
		<div>Móvil: +51-{{ $model->seller->mobile_company }}</div>
		<div>email: {{ $model->seller->email_company }}</div>
	</div>
</body>
</html>