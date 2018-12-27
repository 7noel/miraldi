$(document).ready(function(){

	$('#txtCompany').autocomplete({
		source: "/api/companies/autocompleteAjax/",
		minLength: 4,
		select: function(event, ui){
			$('#company_id').val(ui.item.id);
			$('#lstSeller').focus();
			if (ui.item.country_id==1465) {
				$('#is_import').val(0);
				$('.isImport').hide();
				$('.isNotImport').show();
				$('#document_type_id').val('1');
			} else {
				$('#is_import').val(1);
				$('.isImport').show();
				$('.isNotImport').hide();	
				$('#document_type_id').val('5');
			}
		}
	});

//autocomplete para elementos agregados por javascript
	$(document).on('focus','.txtProof', function (e) {
		$this = this;
		if ( !$($this).data("autocomplete") ) {
			e.preventDefault();
			$($this).autocomplete({
				source: "/api/proofs/autocompleteAjax/1/" + $("#company_id").val(),
				minLength: 4,
				select: function(event, ui){
					$p = ui.item.id;
					setRowProof($this, $p);
				}
			});
		}
	});
	$(document).on('change','.txtCantidad, .txtPrecio, .txtValue, .txtDscto', function (e) {
		calcTotalItem(this);
		calcTotalOrder();
	});

	$('#btnAddProof').click(function(e){
		addRowProof();
	});
	$('#btnAddLetter').click(function(e){
		addRowLetter();
	});
	$('#btnAddLetters').click(function(e){
		addRowLetters();
	});
});

function setRowProof($this, $p) {
	console.log($p)
	if(isProofEnabled($this, $p.id)){
		$($this).parent().parent().find('.proofId').val($p.id);
		// $($this).parent().parent().find('.txtProof').val($p.name);
		$($this).parent().parent().find('.txtEmision').text($p.issued_at);
		$($this).parent().parent().find('.txtVencimiento').text($p.expired_at);
		$($this).parent().parent().find('.txtImporte').text($p.currency.symbol + ' ' + $p.total);
		$($this).parent().parent().find('#addRowProof').focus();
	}
}
function addRowProof() {
	var items = $('#items_d').val();
	if (items>0) {
		if ($("input[name='proofs["+(items-1)+"][id]']").val() == "") {
			$("input[name='proofs["+(items-1)+"][txtProof]']").focus()
		} else{
			renderTemplateRowProof()
		}
	} else{
		renderTemplateRowProof()
	}
}

function addRowLetter() {
	var items = $('#items_l').val();
	if (items>0) {
		if ($("input[name='proofs["+(items-1)+"][id]']").val() == "") {
			$("input[name='proofs["+(items-1)+"][txtProof]']").focus()
		} else{
			renderTemplateRowProof()
		}
	} else{
		renderTemplateRowProof()
	}
}

function validateItem (myElement, id) {
	n = $(myElement).parent().parent().find(id).val();
	n = Math.round(parseFloat(n)*100)/100;
	if (isNaN(n)) {n=0.00};
	$(myElement).parent().parent().find(id).val(n.toFixed(2));
	return n;
}
function calcTotalItem (myElement) {
	cantidad = validateItem(myElement,'.txtCantidad');
	precio = validateItem(myElement,'.txtPrecio');
	value = validateItem(myElement,'.txtValue');
	dscto = validateItem(myElement,'.txtDscto');
	if ($(myElement).hasClass('txtPrecio')) {
		$(myElement).parent().parent().find('.txtValue').val( (precio/1.18).toFixed(2) )
		value = validateItem(myElement,'.txtValue');
	} else if($(myElement).hasClass('txtValue')) {
		$(myElement).parent().parent().find('.txtPrecio').val( (value*1.18).toFixed(2) )
		precio = validateItem(myElement,'.txtPrecio');
	}
	D = Math.round(cantidad * value * dscto) / 100;
	total = Math.round((cantidad*value-D)*100)/100;
	$(myElement).parent().parent().find('.txtTotal').text( total.toFixed(2) );
}
function calcTotalOrder () {
	var gross_value = 0;
	var discount = 0;
	var subtotal = 0;
	var total = 0;
	var q,p,d;
	$('#tableItems tr').each(function (index, vtr) {
		q = parseFloat($(vtr).find('.txtCantidad').val());
		p = parseFloat($(vtr).find('.txtPrecio').val());
		//d = parseFloat($(vtr).find('.txtDscto').val());
		d = 0;
		gross_value = Math.round(q*p*100)/100 + gross_value;
		//discount = Math.round(q*p*d)/100 + discount;
	});

	$('#mGrossValue').text(gross_value.toFixed(2));
	$('#mDiscount').text(discount.toFixed(2));
	calcCost();
}

/**
 * [Convierte $e de la moneda $c0 a la moneda $c]
 * @param  {string} $c0 [moneda original]
 * @param  {string} $c  [nueva moneda]
 * @param  {decimal} $e  [monto]
 * @return {decimal}     [monto en la nueva moneda]
 */
function currencyConverter($c0, $c, $e) {
	var $tc1 = parseFloat($('#exchange').val());
	var $tc2 = parseFloat($('#exchange2').val());// lo equivale a un euro en dolares
	if (isNaN($tc1)) {$tc1=1}
	if (isNaN($tc2)) {$tc2=1}
	if ($c0 == '1') {
		if ($c == '1') {
			return $e;
		} else if ($c == '2') { //
			return $e/$tc1;
		} else if ($c == '3') {
			return ($e/$tc1)/$tc2;
		} else {
			return $e;
		}
	} else if ($c0 == '2') {
		if ($c == '1') {
			return $e*$tc1;
		} else if ($c == '2') {
			return $e;
		} else if ($c == '3') {
			return $e/$tc2;
		} else {
			return $e;
		}
	} else if ($c0 == '3') {
		if ($c == '1') {
			return $e*$tc2*$tc1;
		} else if ($c == '2') {
			return $e*$tc2;
		} else if ($c == '3') {
			return $e;
		} else {
			return $e;
		}
	} else {
		return $e;
	}
}
function activateTemplate (id) {
	var t = document.querySelector(id);
	return document.importNode(t.content, true);
}

function renderTemplateRowProof () {
	var clone = activateTemplate("#template-row-proof");
	var items = $('#items_d').val();
	clone.querySelector("[data-proofId]").setAttribute("name", "proofs[" + items + "][id]");
	clone.querySelector("[data-proof]").setAttribute("name", "proofs[" + items + "][txtProof]");
	clone.querySelector("[data-isdeleted]").setAttribute("name", "proofs[" + items + "][is_deleted]");
	if (items>0) {$("input[name='proofs["+(items-1)+"][txtProof]']").attr('disabled', true);};
	
	items = parseInt(items) + 1;
	$('#items_d').val(items);
	$("#tableItems").append(clone);

	$("input[name='proofs["+(items-1)+"][txtProof]']").focus();
}
function isProofEnabled (myElement, product_id) {
	var b = true
	$('#tableItems tr .proofId').each(function (index, d) {
		if ($(d).val() == product_id) {
			alert("Este documento ya fue registrado");
			setTimeout(function(){
				$(d).parent().find('.isdeleted').attr('checked', false);
				// $(d).parent().find('.txtCantidad').focus();
				$(d).parent().find('#addRowProof').focus();
			}, 300);
			b = false;
		};
	});
	return b;
}
function isLetterEnabled (myElement, product_id) {
	var b = true
	$('#tableLetters tr .letterId').each(function (index, d) {
		if ($(d).val() == product_id) {
			alert("Este producto ya fue registrado");
			setTimeout(function(){
				$(d).parent().find('.isdeleted').attr('checked', false);
				$(d).parent().find('.txtCantidad').focus();
			}, 300);
			b = false;
		};
	});
	return b;
}