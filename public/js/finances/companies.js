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

	$('#btnAddBranch').click(function(e){
		addRowBranch();
	});

	$(document).on('focus','.txtUbigeo', function (e) {
		//console.log($(this));
		$var = {}
		$var.this = this;
		if ( !$($var.this).data("autocomplete") ) {
			e.preventDefault();
			$($var.this).autocomplete({
				source: "/api/ubigeos/autocompleteAjax",
				minLength: 2,
				select: function(event, ui){
					var cod=ui.item.id;
					$($var.this).parent().parent().find('.ubigeoId').val(cod);
				}
			});
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

function addRowBranch() {
	var items = $('#items').val();
	if (items>0) {
		if ($("input[name='branches["+(items-1)+"][name]']").val() == "") {
			console.log('en el segundo if');
			$("input[name='branches["+(items-1)+"][name]']").focus();
		} else if ($("input[name='branches["+(items-1)+"][address]']").val() == "") {
			$("input[name='branches["+(items-1)+"][address]']").focus();
		} else if ($("input[name='branches["+(items-1)+"][ubigeo_id]']").val() == "") {
			$("input[name='branches["+(items-1)+"][ubigeo]']").focus();
		} else{
			renderTemplateRowProduct();
		}
	} else{
		renderTemplateRowProduct();
	}
}

function renderTemplateRowProduct () {
	var clone = activateTemplate("#template-row-item");
	var items = $('#items').val();
	clone.querySelector("[data-branchId]").setAttribute("name", "branches[" + items + "][branch_id]");
	clone.querySelector("[data-ubigeoId]").setAttribute("name", "branches[" + items + "][ubigeo_id]");
	clone.querySelector("[data-name]").setAttribute("name", "branches[" + items + "][name]");
	clone.querySelector("[data-address]").setAttribute("name", "branches[" + items + "][address]");
	clone.querySelector("[data-ubigeo]").setAttribute("name", "branches[" + items + "][ubigeo]");
	clone.querySelector("[data-mobile]").setAttribute("name", "branches[" + items + "][mobile]");
	clone.querySelector("[data-contact]").setAttribute("name", "branches[" + items + "][contact]");
	clone.querySelector("[data-isdeleted]").setAttribute("name", "branches[" + items + "][is_deleted]");
	//if (items>0) {$("input[name='branches["+(items-1)+"][txtProduct]']").attr('disabled', true);};
	
	items = parseInt(items) + 1;
	$('#items').val(items);
	$("#tableItems").append(clone);

	$("input[name='branches["+(items-1)+"][name]']").focus();
}

function activateTemplate (id) {
	var t = document.querySelector(id);
	return document.importNode(t.content, true);
}