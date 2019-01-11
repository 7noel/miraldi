$(document).ready(function () {
	$("form").submit(function(e){
		this.querySelector("[type='submit']").setAttribute("disabled", "disabled");
	})
	$(document).on("click", '.dropdown-submenu a.test', function(e){
		$(this).parent().parent().find('.ul-submenu').not($(this).next('ul')).hide()
		$(this).next('ul').toggle();
		e.stopPropagation();
		e.preventDefault();
	});
	$("[disabled=disabled]").click(function (e) {
		e.preventDefault()
	})
	if (parseInt($('#listDoc').val()) == 6) {
		$('#lstCountry').attr('disabled', false);
		//$('#lstDistrito').removeAttr( "required" );
	} else {
		$('#lstCountry').attr('disabled', true);
		//$('#lstDistrito').attr( "required", "required" );
	}
	if (parseInt($('#lstCountry').val()) == 1465) {
		$('#div-ubigeo').show();
		$('#lstDepartamento').attr( "required", "required" );
		$('#lstProvincia').attr( "required", "required" );
		$('#lstDistrito').attr( "required", "required" );
	} else {
		$('#div-ubigeo').hide();
		$('#lstDepartamento').removeAttr( "required" );
		$('#lstProvincia').removeAttr( "required" );
		$('#lstDistrito').removeAttr( "required" );
	}
	// $(document).on('click', '.btn-delete-item', function (e) {
	// 	e.preventDefault()
	// 	if ($(this).parent().find('.isdeleted').is(':checked')	) {
	// 		$(this).parent().find('.isdeleted').prop('checked', false);
	// 		$(this).parent().parent().toggle('hidden')
	// 	} else {
	// 		$(this).parent().find('.isdeleted').prop('checked', true);
	// 		$(this).parent().parent().toggle('hidden')
	// 	}
	// 		// $(this).parent().find('.isdeleted').prop('checked', true);
	// })
	$(".delete").submit(function(e){
		if ( !confirm("Seguro que desea eliminar el Registro?") )
		{
			e.preventDefault();
			return;
		}
	});
	$(document).on('change', '.uppercase', function (e) {
		var cadena=$(this).val();
		cadena = cadena.replace("  "," ");
		cadena = cadena.toUpperCase();
		$(this).val(cadena);
	})
	
	// $('.uppercase').change(function(){
	// 	var cadena=$(this).val();
	// 	cadena = cadena.replace("  "," ");
	// 	cadena = cadena.toUpperCase();
	// 	$(this).val(cadena);
	// });
 

	//carga departamentos
	$('#lstCountry').change(function(){
		var country = $('#lstCountry').val();
		if (country == 1465) {
			$('#div-ubigeo').show();
			$('#lstDepartamento').attr( "required", "required" );
			$('#lstProvincia').attr( "required", "required" );
			$('#lstDistrito').attr( "required", "required" );
		} else {
			$('#div-ubigeo').hide();
			$('#lstDepartamento').removeAttr( "required" );
			$('#lstProvincia').removeAttr( "required" );
			$('#lstDistrito').removeAttr( "required" );
		}
	});

	//carga provincias
	$('#lstDepartamento').change(function(){
		cargaProvincias();
		var depa=$('#lstDepartamento').val();
		if (depa==='') {$('#lstProvincia').html("");}
		$('#lstDistrito').html("");
		//$('#lstProvincia').focus();
	});
	
	//carga distritos
	$('#lstProvincia').change(function(){
		//alert('pp');
		cargaDistritos();
		var prov=$('#lstProvincia').val();
		if (prov==='') {$('#lstDistrito').html("");}
		//$('#lstDistrito').focus();
	});

	$('#txtcompany').autocomplete({
		source: "/finances/companies/autocomplete",
		minLength: 1,
		select: function(event, ui){
			var cod=ui.item.id;
			$('#company_id').val(cod);
		}
	});

	$('#txtUbigeo').autocomplete({
		source: "api/ubigeos/autocompleteAjax",
		minLength: 2,
		select: function(event, ui){
			var cod=ui.item.id;
			$('#ubigeo_id').val(cod);
		}
	});
	$('#txtuser').autocomplete({
		source: "/guard/users/autocomplete",
		minLength: 2,
		select: function(event, ui){
			var cod=ui.item.id;
			$('#user_id').val(cod);
		}
	});

	$('.btn-print').click(function(e){
		var url = $(this).data('print');
		printExternal(url);
	});

	//carga unidades
	$('#lstUnitTypes').change(function(){ loadUnits(); });
	//carga subcategorias
	$('#lstCategories').change(function(){
		loadSubCategories();
	});
	//carga año de vehiculos para cotizar
	$('#lstVersions').change(function(){
		loadYears();
	});
	$('#lstYears').change(function(){
		loadPriceCar();
	});
	//cargar vista previa imagen
	$(".file_img_preview").change(function(){
		mostrarImagen(this);
	});
	//pasar elementos entre dos selectores multiples
	$('.pasar').click(function() { return !$('#origen option:selected').remove().appendTo('#destino'); });
	$('.quitar').click(function() { return !$('#destino option:selected').remove().appendTo('#origen'); });
	$('.pasartodos').click(function() { $('#origen option:visible').each(function() { $(this).remove().appendTo('#destino'); }); });
	$('.quitartodos').click(function() { $('#destino option:visible').each(function() { $(this).remove().appendTo('#origen'); }); });
	$('#submit-role').click(function() { $('#destino option').prop('selected', 'selected'); });
	$('#groups').change(function(){
		var clasegrupo = $('#groups').val();
		$('.groupx').hide();
		$('.group_'+clasegrupo).show();
		if (clasegrupo==="") {$('.groupx').show();}
	});

	//focus al primer input
	$('form:first *:input[type!=hidden]:first').focus();

	//asignar valor por defecto de fecha
	//if ($('#date').val()=='') { $('#date').val(new Date.today().toString('yyyy-MM-dd')); };
	//if ($('#birth').val()=='') { $('#birth').val(new Date.today().toString('yyyy-MM-dd')); };
	//formatea fechas
	
	var elements = $(".date");
	$.each(elements,function(index,contenido){
		if (!validarFormatoFecha(contenido.innerHTML)) {
			if (contenido.tagName=='INPUT') {
				if(contenido.value!==''){ $(this).val( moment(trim(contenido.value),"YYYY-MM-DD").format("DD/MM/YYYY") ); }
			} else{
				if(trim(contenido.innerHTML)!==''){ $(this).text( moment(contenido.innerHTML,"YYYY-MM-DD").format("DD/MM/YYYY") ); }
			}
		}
	});

	
	//Alista datepicker
	$.datepicker.regional['es'] = {
		closeText: 'Cerrar',
		prevText: '<Ant',
		nextText: 'Sig>',
		currentText: 'Hoy',
		monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
		monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
		dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
		dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
		dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
		weekHeader: 'Sm',
		dateFormat: 'dd/mm/yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''
	};
	$.datepicker.setDefaults($.datepicker.regional['es']);

	$('#date2').datepicker({ format: "dd/mm/yyyy", language: 'es', autoclose: true });
	$('#birth2').datepicker({ format: "dd/mm/yyyy", language: 'es', autoclose: true });
});
	
/*cargar provincias*/
function cargaProvincias(){
	var idDepartamento = $('#lstDepartamento option:selected').val();
	var page ="/listarProvincias/" + idDepartamento;
	if(idDepartamento !== ''){
		$.get(page, function(data){
			$('#lstProvincia').empty();
			$('#lstProvincia').append("<option value=''>Seleccionar</option>");
			$.each(data, function (index, ProvinciaObj) {
				$('#lstProvincia').append("<option value='"+ProvinciaObj.provincia+"'>"+ProvinciaObj.provincia+"</option>");
			});
		});
	}
}

/*cargar distritos*/
function cargaDistritos(){
	var idDepartamento = $('#lstDepartamento option:selected').val();
	var rel=$('#lstProvincia option:selected').val();
	var page = "/listarDistritos/" + idDepartamento + "/" +rel;
	if(rel !==''){
		$.get(page, function(data){
			$('#lstDistrito').empty();
			$('#lstDistrito').append("<option value=''>Seleccionar</option>");
			$.each(data, function (index, DistritoObj) {
				$('#lstDistrito').append("<option value='"+DistritoObj.id+"'>"+DistritoObj.distrito+"</option>");
			});
		});
	}
}
/*cargar unidades*/
function loadUnits(){
	var unit_type_id = $('#lstUnitTypes option:selected').val();
	var page = "/listUnits/" + unit_type_id;
	if(unit_type_id !==''){
		$.get(page, function(data){
			$('#lstUnit').empty();
			$('#lstUnit').append("<option value=''>Seleccionar</option>");
			$.each(data, function (index, Obj) {
				$('#lstUnit').append("<option value='"+Obj.id+"'>"+Obj.name+"</option>");
			});
		});
	} else {
		$('#lstUnit').html("");
	}
}
/*cargar subcategorias*/
function loadSubCategories(){
	var category_id = $('#lstCategories option:selected').val();
	var page = "/listSubCategories/" + category_id;
	if(category_id !==''){
		$.get(page, function(data){
			$('#lstSubCategories').empty();
			$('#lstSubCategories').append("<option value=''>Seleccionar</option>");
			$.each(data, function (index, Obj) {
				$('#lstSubCategories').append("<option value='"+Obj.id+"'>"+Obj.name+"</option>");
			});
		});
	} else {
		$('#lstSubCategories').html("");
	}
}
/*cargar modelos*/
function cargaModelos(){
	var id = $('#brand_id option:selected').val();
	var page = "/listarModelos/" + id;
	if(id !==''){
		$.get(page, function(data){
			$('#model_id').empty();
			$('#model_id').append("<option value=''>Seleccionar</option>");
			$.each(data, function (index, ModelObj) {
				$('#model_id').append("<option value='"+ModelObj.id+"'>"+ModelObj.name+"</option>");
			});
		});
	}
}
function myRound(value, places) {
	var multiplier = Math.pow(10, places);
	return (Math.round(value * multiplier) / multiplier);
}
function arrayToHidden (dato, name, item) {
	var data = "";
	$.each(dato, function(index, value){
		//data = data + "<input type=\"hidden\" name=\""+name+"["+item+"]["+index+"]\" value=\""+value+"\" class=\"data-"+index"\">";
	});
	return data;
}
function generateTds (table) {
	var data = "";
	$.each(table, function(index,Obj){
		data = data+"<td class=\""+Obj.class+"\">"+Obj.value+"</td>";
	});
	return data;
}
function generateBtns (inputs) {
	var data = "";
	$.each(inputs, function(index,Obj){
		data = data + "<input type=\"hidden\" name=\""+Obj.name+"\" value=\""+Obj.value+"\">";
	});
	return "<td>"+data+"<a href=\"#\" class=\"btn-edit-detail btn btn-primary btn-xs\"><span class=\"glyphicon glyphicon-pencil\" aria-hidden=\"true\"></span> Editar</a> <a href=\"#\" class=\"btn-delete-detail btn btn-danger btn-xs\"><span class=\"glyphicon glyphicon-trash\" aria-hidden=\"true\"></span> Eliminar</a></td>";
}
function trim(cadena){
	cadena=cadena.replace(/^\s+/,'').replace(/\s+$/,'');
	return(cadena);
}
function validarFormatoFecha(campo) {
	var RegExPattern = /^\d{1,2}\/\d{1,2}\/\d{2,4}$/;
	if ((campo.match(RegExPattern)) && (campo!=='')) {
		return true;
	} else {
		return false;
	}
}
function loadYears () {
	var version_id = $('#lstVersions option:selected').val();
	var page = "/listCars/" + version_id;
	if(version_id !==''){
		$.get(page, function(data){
			$('#lstYears').empty();
			$('#lstYears').append("<option value=''>Seleccionar</option>");
			$.each(data, function (index, Obj) {
				$('#lstYears').append("<option value='"+Obj.id+"'>"+Obj.manufacture_year+" / "+Obj.model_year+"</option>");
			});
		});
	} else {
		$('#lstYears').html("");
	}
}
function loadPriceCar () {
	var catalog_car_id = $('#lstYears option:selected').val();
	var page = "/ajaxGetCar/" + catalog_car_id;
	if(catalog_car_id !==''){
		$.get(page, function(data){
			console.log(data);
			$('#price').val(data.price);
			$('#set_price').val(data.price);
			if (! ($('#currency_id').val() == data.currency_id)) {
				$('#currency_id').val(data.currency_id);
				$('.currency').text(data.currency.symbol);
			}
		});
	} else {
		$('#price').val('');
		$('#set_price').val('');
	}
}
function mostrarImagen(input) {
	if (input.files && input.files[0]) {
		console.log($(input).parent());
		var reader = new FileReader();
		reader.onload = function (e) {
			$(input).parent().parent().find('.img_preview').attr('src', e.target.result);
		}
		reader.readAsDataURL(input.files[0]);
	}
}
function printExternal(url) {
    var printWindow = window.open( url, 'Print');
    printWindow.addEventListener('load', function(){
        setTimeout(function(){
        	printWindow.print();
        	setTimeout(function(){printWindow.close();}, 1);
        }, 500);
        //printWindow.onfocus=function(){ printWindow.close();}
        //printWindow.close();
    }, true);
}