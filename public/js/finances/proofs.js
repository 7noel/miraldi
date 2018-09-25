$(document).ready(function(){
	if ($('#is_import').val()==1) {
		$('.isImport').show();
		$('.isNotImport').hide();
		$('#currency_cost').val($('#currency_id').val());
		calcCost();
	} else {
		$('.isImport').hide();
		$('.isNotImport').show();
	}

	if ($('#with_tax').val() == 1) {
		$('.withTax').show();
		$('.withoutTax').hide();
	} else {
		$('.withTax').hide();
		$('.withoutTax').show();
	}

	if ($('#payment_condition_id').val()==1) {
		$('.due_date').hide();
	} else {
		$('.due_date').show();
	}

	$('.currency').each(function () {
		$currency = $(this);
		newCurrency = $currency.val();
		setCurrencyExpense($currency, newCurrency);
	});
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
	$(document).on('focus','.txtProduct', function (e) {
		$this = this;
		if ( !$($this).data("autocomplete") ) {
			e.preventDefault();
			$($this).autocomplete({
				source: "/api/products/autocompleteAjax",
				minLength: 4,
				select: function(event, ui){
					$p = ui.item.id;
					setRowProduct($this, $p);
				}
			});
		}
	});
	$(document).on('change','.txtCantidad, .txtPrecio, .txtValue, .txtDscto', function (e) {
		calcTotalItem(this);
		calcTotalOrder();
	});

	$(document).on('click','.expenses .btn', function (e) {
		e.preventDefault();
		$currency = $(this).parent().find('.currency');
		newCurrency = parseInt($currency.val()) + 1;
		if (newCurrency > 3) {newCurrency = 1;}
		setCurrencyExpense($currency, newCurrency);
	});
	
	$(document).on('change','.expense', function (e) {
		validateItem(this, '#'+this.id);
		calcCost();
	});
	$(document).on('change','#exchange, #exchange2, #c1, #c2, #c3, #c4, #c5, #c6, #c7, #c8, #currency_id, #currency_cost', function (e) {
		calcCost();
	});
	$(document).on('change','#payment_condition_id', function (e) {
		if ($('#payment_condition_id').val()==1) {
			$('.due_date').hide();
		} else {
			$('.due_date').show();
		}
	});

	$('#btnAddProduct').click(function(e){
		addRowProduct();
	});
});

function setCurrencyExpense($currency, newCurrency) {
	currency = $currency.val();
	if (newCurrency == 1) {
		$currency.parent().find('.labelCurrency').text('S/');
	} else if (newCurrency == 2) {
		$currency.parent().find('.labelCurrency').text('$');
	} else {
		$currency.parent().find('.labelCurrency').text('€');
	}
	$currency.val(newCurrency);
}
function setRowProduct($this, $p) {
	if(isDesignEnabled($this, $p.id)){
		$($this).parent().parent().find('.productId').val($p.id);
		$($this).parent().parent().find('.txtProduct').val($p.name);
		$($this).parent().parent().find('.unitId').val($p.unit_id);
		$($this).parent().parent().find('.txtPrecio').val($p.value);
		$($this).parent().parent().find('.txtValue').val(($p.value*1.18).toFixed(2));
		$($this).parent().parent().find('.intern_code').text($p.intern_code);
		$($this).parent().parent().find('.txtCantidad').focus();
	}
}
function addRowProduct(data='') {
	var items = $('#items').val();
	if (items>0) {
		if ($("input[name='details["+(items-1)+"][product_id]']").val() == "") {
			$("input[name='details["+(items-1)+"][txtProduct]']").focus();
		} else{
			renderTemplateRowProduct(data);
		};
	} else{
		renderTemplateRowProduct(data);
	};
	if ($('#is_import').val()==1) {
		$('.isImport').show();
		$('.isNotImport').hide();
	} else {
		$('.isImport').hide();
		$('.isNotImport').show();
	}

	if ($('#with_tax').val() == 1){
		$('.withTax').show();
		$('.withoutTax').hide();
	} else {
		$('.withTax').hide();
		$('.withoutTax').show();
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

function calcFactor() {
	const $cc = $('#currency_cost').val();
	const $c0 = $('#currency_id').val();
	var exw = parseFloat($('#mGrossValue').text());
	if ($('#is_import').val()==1) {
		const $c1 = $('#c1').val(), $c2 = $('#c2').val(), $c3 = $('#c3').val(), $c4 = $('#c4').val(), $c5 = $('#c5').val(), $c6 = $('#c6').val(), $c7 = $('#c7').val(), $c8 = $('#c8').val();
		var $e1 = parseFloat($('#e1').val()), $e2 = parseFloat($('#e2').val()), $e3 = parseFloat($('#e3').val()), $e4 = parseFloat($('#e4').val()), $e5 = parseFloat($('#e5').val()), $e6 = parseFloat($('#e6').val()), $e7 = parseFloat($('#e7').val()), $e8 = parseFloat($('#e8').val());
		$e1 = currencyConverter($c1, $c0, $e1);
		$e2 = currencyConverter($c2, $c0, $e2);
		$e3 = currencyConverter($c3, $c0, $e3);
		$e4 = currencyConverter($c4, $c0, $e4);
		$e5 = currencyConverter($c5, $c0, $e5);
		$e6 = currencyConverter($c6, $c0, $e6);
		$e7 = currencyConverter($c7, $c0, $e7);
		$e8 = currencyConverter($c8, $c0, $e8);
		var e = $e1 + $e2 + $e3 + $e4 + $e5 + $e6 + $e7 + $e8;
		var fob = exw + $e1
		var cif = exw + $e1 + $e2 + $e3
		var tot = exw + e
		$('#exw').text(currencyConverter($c0, $cc, exw).toFixed(2))
		$('#fob').text(currencyConverter($c0, $cc, fob).toFixed(2))
		$('#cif').text(currencyConverter($c0, $cc, cif).toFixed(2))
		$('#tot').text(currencyConverter($c0, $cc, tot).toFixed(2))
	} else {
		var e = 0
	}
	var subtotal = exw;
	var total = Math.round(subtotal * (100 + 18))/100;
	$('#mSubTotal').text(subtotal.toFixed(2));
	$('#mTotal').text(total.toFixed(2));
	if (exw > 0) {
		console.log("Factor: " + ((exw + e)/(exw)))
		return (exw + e)/(exw);
	} else {
		return 1;
	}
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
function calcCost() {
	$factor = calcFactor();
	$('#factor').val($factor.toFixed(4))
	const $c0 = $('#currency_id').val();
	const $cc = $('#currency_cost').val();
	$('#tableItems tr .txtPrecio').each(function (index, d) {
		$(d).parent().parent().find('.cost').val( ($(d).val() * $factor).toFixed(2) );
		$(d).parent().parent().find('.txtCost').val( ( currencyConverter($c0, $cc, $(d).val()) * $factor).toFixed(2) );
	});

}

function activateTemplate (id) {
	var t = document.querySelector(id);
	return document.importNode(t.content, true);
}

function renderTemplateRowProduct (data) {
	if (data != "") {
		ele = document.getElementById("tableItems").lastElementChild.querySelector("[data-product]");
		if (!isDesignEnabled(ele, data.id)) {return true;}
		
		
	}
	var clone = activateTemplate("#template-row-item");
	var items = $('#items').val();
	clone.querySelector("[data-productid]").setAttribute("name", "details[" + items + "][product_id]");
	clone.querySelector("[data-unitid]").setAttribute("name", "details[" + items + "][unit_id]");
	clone.querySelector("[data-product]").setAttribute("name", "details[" + items + "][txtProduct]");
	clone.querySelector("[data-cantidad]").setAttribute("name", "details[" + items + "][quantity]");
	clone.querySelector("[data-value]").setAttribute("name", "details[" + items + "][value]");
	clone.querySelector("[data-precio]").setAttribute("name", "details[" + items + "][price]");
	clone.querySelector("[data-cost]").setAttribute("name", "details[" + items + "][cost]");
	clone.querySelector("[data-textcost]").setAttribute("name", "details[" + items + "][text_cost]");
	clone.querySelector("[data-isdeleted]").setAttribute("name", "details[" + items + "][is_deleted]");
	if (items>0) {$("input[name='details["+(items-1)+"][txtProduct]']").attr('disabled', true);};
	
	items = parseInt(items) + 1;
	$('#items').val(items);
	$("#tableItems").append(clone);
	el = document.getElementById("tableItems").lastElementChild.querySelector("[data-product]");
	if (data != '') {
		setRowProduct(el, data);
	}

	$("input[name='details["+(items-1)+"][txtProduct]']").focus();
}
function isDesignEnabled (myElement, product_id) {
	var b = true
	$('#tableItems tr .productId').each(function (index, d) {
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