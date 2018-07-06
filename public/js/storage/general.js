$(document).ready(function(){
	console.log($('#useSetValue').val() == 1);
	if ($('#useSetValue').is(':checked')) {
		$('#value').removeAttr("readonly");
	}
	$('#btnNewAccessory').click(function() {
		var items = $('#items-accessory').val();
		if (items>0 && $("input[name='accessories["+(items-1)+"][accessory_id]']").val() == "") {
			$("input[name='accessories["+(items-1)+"][accessory]']").focus();
		} else {
			renderTemplateRowAccessory();
		};
	});

	$('#btnNewAttribute').click(function() {
		var items = $('#items-attribute').val();
		console.log("items = " + items)
		if (items>0 && $("input[name='attributes["+(items-1)+"][id]']").val() == "") {
			$("input[name='attributes["+(items-1)+"][name]']").focus();
		} else {
			renderTemplateRowAttribute();
		};
	});

	$('#profit_margin').change(function (e) {
		if (!$('#useSetValue').is(':checked')) {
			$('#value').val(parseFloat($('#last_purchase').val()) * (100 + parseFloat($('#profit_margin').val()))/100).toFixed(2);
		}
	});

	$(document).on('focus','.txtAccessory', function (e) {
		//console.log($(this));
		if ( !$(this).data("autocomplete") ) {
			e.preventDefault();
			$(this).autocomplete({
				source: "/api/products/autocompleteAjax",
				minLength: 4,
				select: function(event, ui){
					if(isDesignEnabled(this, ui.item.id.internCode)){
						$(this).parent().parent().find('.internCode').text(ui.item.id.intern_code);
						$(this).parent().parent().find('.accessoryId').val(ui.item.id.id);
						$('#btnNewAccessory').focus();
					}
				}
			});
		}
	});
	$(document).on('change','#useSetValue', function (e) {
		if ($('#useSetValue').is(':checked')) {
			$('#value').removeAttr("readonly");
			$('#value').focus();
		} else {
			$('#value').val(parseFloat($('#last_purchase').val()) * (100 + parseFloat($('#profit_margin').val()))/100).toFixed(2);
			$('#value').attr( "readonly", "readonly" );
		}

	});

});


function activateTemplate (id) {
	var t = document.querySelector(id);
	return document.importNode(t.content, true);
}

function renderTemplateRowAccessory () {
	var clone = activateTemplate("#template-row-accessory");
	var items = $('#items-accessory').val();
	clone.querySelector("[data-accessory]").setAttribute("name", "accessories[" + items + "][accessory]");
	clone.querySelector("[data-accessoryid]").setAttribute("name", "accessories[" + items + "][accessory_id]");
	clone.querySelector("[data-isdeleted]").setAttribute("name", "accessories[" + items + "][is_deleted]");
	if (items>0) {$("input[name='accessories["+(items-1)+"][txtAccessory]']").attr('disabled', true);};
	
	$("#tbodyAccessories").append(clone);
	items = parseInt(items) + 1;
	$('#items-accessory').val(items);
}
function renderTemplateRowAttribute () {
	var clone = activateTemplate("#template-row-attribute");
	var items = $('#items-attribute').val();
	clone.querySelector("[data-name]").setAttribute("name", "attributes[" + items + "][name]");
	clone.querySelector("[data-value]").setAttribute("name", "attributes[" + items + "][value]");
	clone.querySelector("[data-isdeleted]").setAttribute("name", "attributes[" + items + "][is_deleted]");
	//if (items>0) {$("input[name='accessories["+(items-1)+"][name]']").attr('disabled', true);};
	
	$("#tbodyAttributes").append(clone);
	items = parseInt(items) + 1;
	$('#items-attribute').val(items);
}
function isDesignEnabled (myElement, accessoryId) {
	var b = true
	$('#tableItems tr .accessoryId').each(function (index, d) {
		if ($(d).val() == accessoryId) {
			alert("Este diseño ya fue registrado");
			setTimeout(function(){ 
				$(myElement).parent().parent().find('.txtAccessory').val('');
				//$(d).parent().find('.isdeleted').attr('checked', false);
				$('#btnNewAccessory').focus();
			}, 300);
			b = false;
		};
	});
	return b;
}