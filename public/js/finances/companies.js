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
		if ($("input[name='branchs["+(items-1)+"][name]']").val() == "") {
			console.log('en el segundo if');
			$("input[name='branchs["+(items-1)+"][name]']").focus();
		} else if ($("input[name='branchs["+(items-1)+"][address]']").val() == "") {
			$("input[name='branchs["+(items-1)+"][address]']").focus();
		} else if ($("input[name='branchs["+(items-1)+"][ubigeo_id]']").val() == "") {
			$("input[name='branchs["+(items-1)+"][ubigeo]']").focus();
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
	clone.querySelector("[data-branchId]").setAttribute("name", "branchs[" + items + "][branch_id]");
	clone.querySelector("[data-ubigeoId]").setAttribute("name", "branchs[" + items + "][ubigeo_id]");
	clone.querySelector("[data-name]").setAttribute("name", "branchs[" + items + "][name]");
	clone.querySelector("[data-address]").setAttribute("name", "branchs[" + items + "][address]");
	clone.querySelector("[data-ubigeo]").setAttribute("name", "branchs[" + items + "][ubigeo]");
	clone.querySelector("[data-mobile]").setAttribute("name", "branchs[" + items + "][mobile]");
	clone.querySelector("[data-contact]").setAttribute("name", "branchs[" + items + "][contact]");
	clone.querySelector("[data-isdeleted]").setAttribute("name", "branchs[" + items + "][is_deleted]");
	//if (items>0) {$("input[name='branchs["+(items-1)+"][txtProduct]']").attr('disabled', true);};
	
	items = parseInt(items) + 1;
	$('#items').val(items);
	$("#tableItems").append(clone);

	$("input[name='branchs["+(items-1)+"][name]']").focus();
}

function activateTemplate (id) {
	var t = document.querySelector(id);
	return document.importNode(t.content, true);
}