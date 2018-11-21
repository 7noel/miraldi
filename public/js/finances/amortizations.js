$(document).ready(function(){

	$(document).on('change','.txtCurrency, .txtExchange, .txtValue', function (e) {
		calcTotalItem(this);
		calcTotalAmortization();
	});

	$('#btnAddPay').click(function(e){
		addRowAmortization();
	});
});

function addRowAmortization() {
	var items = $('#items').val();
	if (items>0) {
		if ($("select[name='amortizations["+(items-1)+"][bank_id]']").val() == "") {
			$("select[name='amortizations["+(items-1)+"][txtBank]']").focus();
		} else{
			renderTemplateRowProduct();
		};
	} else{
		renderTemplateRowProduct();
	};
}

function validateItem (myElement, id) {
	n = $(myElement).parent().parent().find(id).val();
	n = Math.round(parseFloat(n)*100)/100;
	if (isNaN(n)) {n=0.00};
	$(myElement).parent().parent().find(id).val(n.toFixed(2));
	return n;
}
function calcTotalItem (myElement) {
	cur1 = $(myElement).parent().parent().find('.txtCurrency').val()
	cur2 = $('#currency_id').val()
	exchange = validateItem(myElement, '.txtExchange')
	if (cur1 == cur2) {
		$(myElement).parent().parent().find('.txtExchange').val('1')
		exchange = 1
	} else {
		if (exchange > 0) {
			$(myElement).parent().parent().find('.txtExchange').focus()
			return true
		}
	}
	value = validateItem(myElement,'.txtValue');
	value_proof = currencyConverter(cur1, cur2, value, exchange)
	value_payment = value
	$(myElement).parent().parent().find('.valueProof').val(value)
	$(myElement).parent().parent().find('.valuePayment').val(value_payment)

}
function calcTotalAmortization () {
	var total = Math.round(parseFloat( $('#total').val() )*100)/100;
	var amortization = 0;
	var a;
	$('#tableItems tr').each(function (index, vtr) {
		a = parseFloat($(vtr).find('.valueProof').val() );
		amortization += a
	});

	$('#amortization').val(amortization.toFixed(2));
}

function activateTemplate (id) {
	var t = document.querySelector(id);
	return document.importNode(t.content, true);
}

function renderTemplateRowProduct () {
	var clone = activateTemplate("#template-row-item");
	var items = $('#items').val();
	clone.querySelector("[data-proofId]").setAttribute("name", "amortizations[" + items + "][proof_id]");
	clone.querySelector("[data-valueProof]").setAttribute("name", "amortizations[" + items + "][value_proof]");
	clone.querySelector("[data-valuePayment]").setAttribute("name", "amortizations[" + items + "][value_payment]");
	clone.querySelector("[data-bankId]").setAttribute("name", "payments[" + items + "][bank_id]");
	clone.querySelector("[data-fecha]").setAttribute("name", "payments[" + items + "][issued_at]");
	clone.querySelector("[data-number]").setAttribute("name", "payments[" + items + "][number]");
	clone.querySelector("[data-currency]").setAttribute("name", "payments[" + items + "][currency_id]");
	clone.querySelector("[data-value]").setAttribute("name", "payments[" + items + "][value]");
	clone.querySelector("[data-exchange]").setAttribute("name", "payments[" + items + "][exchange]");
	clone.querySelector("[data-isdeleted]").setAttribute("name", "amortizations[" + items + "][is_deleted]");
	if (items>0) {$("input[name='amortizations["+(items-1)+"][bank_id]']").attr('disabled', true);};
	
	items = parseInt(items) + 1;
	$('#items').val(items);
	$("#tableItems").append(clone);
	$("input[name='payments["+(items-1)+"][bank_id]']").focus();
}


/**
 * [Convierte $e de la moneda $c0 a la moneda $c]
 * @param  {string} $c0 [moneda original]
 * @param  {string} $c  [nueva moneda]
 * @param  {decimal} $e  [monto]
 * @return {decimal}     [monto en la nueva moneda]
 */
function currencyConverter($c0, $c, $e, $t) {
	var $tc1 = $t;
	var $tc2 = 1;
	// var $tc2 = parseFloat($('#exchange2').val());// lo equivale a un euro en dolares
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