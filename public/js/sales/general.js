var descuento1 = 0;
var descuento2 = 0;
var addAccessory = false;
$(document).ready(function(){
	$(document).keydown(function(e) {
		tecla=(document.all) ? e.keyCode : e.which; 
		if (tecla==65 && e.altKey){
			addRowProduct();
		}
	})
	if ($('#company_doc').val() == 1) {
		if ($('#document_type_id').val() == '' || $('#document_type_id').val() == 2) {
			$('#document_type_id').val(1)
		}
	} else {
		if ($('#document_type_id').val() == '' || $('#document_type_id').val() == 1) {
			$('#document_type_id').val(2)
		}
	}

	if ($('#with_tax').val() == 1) {
		$('.withTax').show();
		$('.withoutTax').hide();
	} else {
		$('.withTax').hide();
		$('.withoutTax').show();
	}

	$('#with_tax').change(function(){
		$('.withTax').toggle();
		$('.withoutTax').toggle();
	})

	$('#txtCompany').autocomplete({
		source: "/api/companies/autocompleteAjax/",
		minLength: 4,
		select: function(event, ui){
			$('#company_id').val(ui.item.id);
			$('#company_doc').val(ui.item.id_type_id);
			$('#lstSeller').focus();
			if (ui.item.id_type_id == 1) {
				if ($('#document_type_id').val() == '' || $('#document_type_id').val() == 2) {
					$('#document_type_id').val(1)
				}
			} else {
				if ($('#document_type_id').val() == '' || $('#document_type_id').val() == 1) {
					$('#document_type_id').val(2)
				}
			}
		}
	});
	$(document).on('click', '.btn-delete-item', function (e) {
		e.preventDefault()
		if ($(this).parent().find('.isdeleted').is(':checked')	) {
			$(this).parent().find('.isdeleted').prop('checked', false);
			$(this).parent().parent().toggle('hidden')
		} else {
			$(this).parent().find('.isdeleted').prop('checked', true);
			$(this).parent().parent().toggle('hidden')
		}
		calcTotalOrder()
	})

//autocomplete para elementos agregados por javascript
	$(document).on('focus','.txtProduct', function (e) {
		//console.log($(this));
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
	$(document).on('change','.txtCantidad, .txtPrecio, .txtValue, .txtDscto, .txtDscto2', function (e) {
		calcTotalItem(this);
		calcTotalOrder();
	});

	$('#btnAddProduct').bind("click touchstart", function(e){
		addRowProduct();
	});
});

function setRowProduct($this, $p) {
	//console.log($categories)
	if(isDesignEnabled($this, $p.id)){
		$($this).parent().parent().find('.productId').val($p.id);
		$($this).parent().parent().find('.txtProduct').val($p.name);
		$($this).parent().parent().find('.unitId').val($p.unit_id);
		$($this).parent().parent().find('.txtValue').val($p.value);
		$($this).parent().parent().find('.txtPrecio').val(($p.value*1.18).toFixed(2));
		$($this).parent().parent().find('.txtDscto').val(window.descuento1);
		$($this).parent().parent().find('.txtDscto2').val(window.descuento2);
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
	if (id=='.txtDscto') {window.descuento1 = n.toFixed(2)}
	if (id=='.txtDscto2') {window.descuento2 = n.toFixed(2)}
	return n;
}
function calcTotalItem (myElement) {
	cantidad = validateItem(myElement,'.txtCantidad');
	precio = validateItem(myElement,'.txtPrecio');
	value = validateItem(myElement,'.txtValue');
	dscto = validateItem(myElement,'.txtDscto');
	dscto2 = validateItem(myElement,'.txtDscto2');
	if ($(myElement).hasClass('txtPrecio')) {
		$(myElement).parent().parent().find('.txtValue').val( (precio/1.18).toFixed(2) )
		value = validateItem(myElement,'.txtValue');
	} else if($(myElement).hasClass('txtValue')) {
		$(myElement).parent().parent().find('.txtPrecio').val( (value*1.18).toFixed(2) )
		precio = validateItem(myElement,'.txtPrecio');
	}
	// D = Math.round(cantidad * value * dscto) / 100;
	total = Math.round((cantidad*value)*(100-dscto)*(100-dscto2)/100)/100;
	D = Math.round(cantidad * value - total) / 100;
	// total = Math.round((cantidad*value-D)*100)/100;
	$(myElement).parent().parent().find('.txtTotal').text( total.toFixed(2) );
}
function calcTotalOrder () {
	var gross_value = 0;
	var d_items = 0;
	var subtotal = 0;
	var total = 0;
	var q,p,d1,d2,t,pu;
	$('#tableItems tr').each(function (index, vtr) {
		if (!($(vtr).find('.isdeleted').is(':checked'))) {
			q = parseFloat($(vtr).find('.txtCantidad').val());
			v = parseFloat($(vtr).find('.txtValue').val());
			p = parseFloat($(vtr).find('.txtPrecio').val());
			// v = p * 100 / (100 + 18);
			// v = parseFloat($(vtr).find('.txtValue').val());
			d1 = parseFloat($(vtr).find('.txtDscto').val());
			d2 = parseFloat($(vtr).find('.txtDscto2').val());
			vt = Math.round(q*v*(100-d1)*(100-d2)/100) / 100 // total por item
			t = Math.round(vt*118) / 100;
			console.log(vt)
			console.log(t)
			discount = Math.round(100*q*v)/100 - vt;

			gross_value += Math.round(100*q*v)/100;
			d_items += discount;
			subtotal += vt;
			total += t;
			// gross_value = (Math.round(q*v*100)/100) + gross_value;
			// discount = (Math.round(q*v*d)/100) + discount;
			// subtotal = gross_value - (Math.round(q*v*d)/100) + subtotal;
		}
	});
	gross_value = Math.round(100 * gross_value) / 100;
	subtotal = Math.round(100 * subtotal) / 100;
	total = Math.round(100 * total) / 100;
	// if ($('#with_tax').val() == 1){
	// 	subtotal = Math.round(total * 10000 / (100 + 18)) / 100;
	// } else {
	// 	total = Math.round(subtotal * (100 + 18))/100;
	// }
	// discount = (gross_value - subtotal);


	$('#mGrossValue').text(gross_value.toFixed(2));
	$('#mDiscount').text(d_items.toFixed(2));
	$('#mSubTotal').text(subtotal.toFixed(2));
	$('#mTotal').text(total.toFixed(2));
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
	clone.querySelector("[data-precio]").setAttribute("name", "details[" + items + "][price]");
	clone.querySelector("[data-value]").setAttribute("name", "details[" + items + "][value]");
	clone.querySelector("[data-dscto]").setAttribute("name", "details[" + items + "][d1]");
	clone.querySelector("[data-dscto2]").setAttribute("name", "details[" + items + "][d2]");
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
				if (window.addAccessory == true) {$(myElement).parent().parent().find('.txtProduct').val('');}
				$(d).parent().find('.isdeleted').attr('checked', false);
				$(d).parent().find('.txtCantidad').focus();
			}, 300);
			b = false;
		};
	});
	return b;
}