$(document).ready(function(){

	$('#btnAddModelo').click(function(e){
		e.preventDefault();
		addRowModelo();
	});

	$('#btnAddColor').click(function(e){
		e.preventDefault();
		addRowColor();
	});
	$(document).on('change','#tableModelos .name', function (e) {
		var $count = 0
		$name = $(this).val()
		$('#tableModelos tr .name').each(function (index, d) {
			if ($(d).val() == $name) {
				$count = $count + 1
			};
			if ($count == 2) {
				alert("Este modelo ya fue registrado")
				$(this).val("")
			}
		});
	});

	$(document).on('change','#tableColors .code', function (e) {
		var $count = 0
		$color = $(this).val()
		$('#tableColors tr .code').each(function (index, d) {
			if ($(d).val() == $color) {
				$count = $count + 1
			};
			if ($count == 2) {
				alert("Este color ya fue registrado")
				$(this).val("")
			}
		});
	});
});

function activateTemplate (id) {
	var t = document.querySelector(id);
	return document.importNode(t.content, true);
}

function addRowModelo() {
	var items = $('#items_1').val();
	if (items>0) {
		if ($("input[name='modelos["+(items-1)+"][name]']").val() == "") {
			$("input[name='modelos["+(items-1)+"][name]']").focus();
		} else{
			renderTemplateRowModelo();
		};
	} else{
		renderTemplateRowModelo();
	};
}

function renderTemplateRowModelo () {
	var clone = activateTemplate("#template-row-modelo");
	var items = $('#items_1').val();
	clone.querySelector("[data-name]").setAttribute("name", "modelos[" + items + "][name]");
	clone.querySelector("[data-description]").setAttribute("name", "modelos[" + items + "][description]");

	//clone.querySelector("[data-isdeleted]").setAttribute("name", "modelos[" + items + "][is_deleted]");
	
	items = parseInt(items) + 1;
	$('#items_1').val(items);
	$("#tableModelos").append(clone);
	$("input[name='modelos["+(items-1)+"][name]']").focus();
}

function addRowColor() {
	var items = $('#items_2').val();
	if (items>0) {
		if ($("input[name='colors["+(items-1)+"][code]']").val() == "") {
			$("input[name='colors["+(items-1)+"][code]']").focus();
		} else{
			renderTemplateRowColor();
		};
	} else{
		renderTemplateRowColor();
	};
}

function renderTemplateRowColor () {
	var clone = activateTemplate("#template-row-color");
	var items = $('#items_2').val();
	clone.querySelector("[data-code]").setAttribute("name", "colors[" + items + "][code]");
	clone.querySelector("[data-otherCode]").setAttribute("name", "colors[" + items + "][other_code]");
	clone.querySelector("[data-description]").setAttribute("name", "colors[" + items + "][description]");
	clone.querySelector("[data-modelos]").setAttribute("name", "colors[" + items + "][modelos]");
	clone.querySelector("[data-isTricapa]").setAttribute("name", "colors[" + items + "][is_tricapa]");
	clone.querySelector("[data-hasBrillo]").setAttribute("name", "colors[" + items + "][has_brillo_directo]");

	clone.querySelector("[data-isdeleted]").setAttribute("name", "colors[" + items + "][is_deleted]");
	
	items = parseInt(items) + 1;
	$('#items_2').val(items);
	$("#tableColors").append(clone);
	$("input[name='colors["+(items-1)+"][name]']").focus();
}