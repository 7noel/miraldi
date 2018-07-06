$(document).ready(function(){
	if (parseInt($('#listDoc').val()) == 1 || parseInt($('#listDoc').val()) == 6) {
		$('.div_ruc').show();
		$('.div_dni').hide();
	} else if (parseInt($('#listDoc').val()) > 1 && parseInt($('#listDoc').val()) < 6) {
		$('.div_ruc').hide();
		$('.div_dni').show();
	} else{
		$('.div_ruc, .div_dni').hide();
	}
	$('#listDoc').change(function(){
		var doc = parseFloat($('#listDoc').val());
		if (doc == 1 || doc == 6) {
			$('.div_ruc').show();
			$('.div_dni').hide();
		} else if (doc > 1) {
			$('.div_ruc').hide();
			$('.div_dni').show();
		} else{
			$('.div_ruc, .div_dni').hide();
		}
		if (doc == 6) {
			$('#lstCountry').attr('disabled', false);
		} else {
			$('#lstCountry').val(1465);
			$('#lstCountry').attr('disabled', true);
		}
	});
	$('#doc').change(function(){
		var ruc = trim($('#doc').val());
		$('#doc').val(ruc);
		var id = $('#listDoc').val();
		if (ruc.length == 11 && id == 1) {
			getDataPadron(ruc);
		}
	});

});

function getDataPadron (ruc) {
	var url = "http://api.noelhh.com/sunat/ruc/" + ruc;
	$.get(url, function(data){
		console.log(data);
		if (data) {
			$('#company_name').val(data.razon_social);
			$('#address').val(data.direccion);
			$('#lstDepartamento').val(data.ubigeo.departamento);
			$('#lstProvincia').val(data.ubigeo.provincia);
			$('#lstDistrito').val(data.ubigeo.id);
		}
	});
}