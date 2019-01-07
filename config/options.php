<?php 
return array(
	'last_number' => [
		'1' => [// importaciones
			'1' => 0, //quote
			'2' => 0, //order
			'3' => 0, //letter
		],
		'2' => [// herramax
			'1' => 0, //quote
			'2' => 0, //order
			'3' => 0, //letter
		],
		'3' => [// miraldi
			'1' => 0, //quote
			'2' => 0, //order
			'3' => 0, //letter
		],
	],
	'product_status' => [
		''=>'Status',
		'1'=>'Activo',
		'3'=>'A pedido',
		'2'=>'Inactivo',
	],
	'proof_types' => [
		'0' => 'Ninguno',
		'1' => 'issuance_vouchers',
		'2' => 'reception_vouchers',
		'3' => 'issuance_letters',
		'4' => 'reception_letters',
	],
	'mov' => [
		'' => 'Seleccionar',
		'1' => 'Entrada',
		'0' => 'Salida',
	],
	'purchase_status' => [],
	'quote_status' => [
		'0' => 'REGISTRADO',
		'1' => 'PROCESADO',
		'6' => 'ANULADO',
	],
	'order_status' => [
		'REGISTRADO',
		'VERIFICADO',
		'APROBADO',
		'FACTURADO',
		'ENVIADO',
		'CANCELADO',
		'ANULADO',
	],
	'tax' => [
		'igv' => 18
	],
	'table_sunat' => [
		'tipo_comprobante' => [
			'' => 'Seleccionar',
			'1' => 'FACTURA',
			'2' => 'BOLETA',
			'3' => 'NOTA DE CRÉDITO',
			'4' => 'NOTA DE DÉBITO'
		],
		'sunat_transaction' => [
			'' => 'Seleccionar',
			'1' => 'VENTA INTERNA',
			'2' => 'EXPORTACIÓN',
			'3' => 'NO DOMICILIADO',
			'4' => 'VENTA INTERNA – ANTICIPOS',
			'5' => 'VENTA ITINERANTE',
			'6' => 'FACTURA GUÍA',
			'7' => 'VENTA ARROZ PILADO',
			'8' => 'FACTURA - COMPROBANTE DE PERCEPCIÓN',
			'10' => 'FACTURA - GUÍA REMITENTE',
			'11' => 'FACTURA - GUÍA TRANSPORTISTA',
			'12' => 'BOLETA DE VENTA – COMPROBANTE DE PERCEPCIÓN',
			'13' => 'GASTO DEDUCIBLE PERSONA NATURAL'
		],
		'cliente_tipo_de_documento' =>[
			'' => 'Seleccionar',
			'6' => 'RUC - REGISTRO ÚNICO DE CONTRIBUYENTE',
			'1' => 'DNI - DOC. NACIONAL DE IDENTIDAD',
			'-' => 'VARIOS - VENTAS MENORES A S/.700.00 Y OTROS',
			'4' => 'CARNET DE EXTRANJERÍA',
			'7' => 'PASAPORTE',
			'A' => 'CÉDULA DIPLOMÁTICA DE IDENTIDAD',
			'0' => 'NO DOMICILIADO, SIN RUC (EXPORTACIÓN)'
		],
		'moneda' => [
			'' => 'Seleccionar',
			'1' => 'SOLES',
			'2' => 'DÓLARES',
			'3' => 'EUROS'
		],
		'percepcion_tipo'=>[
			'' => 'Seleccionar',
			'1' => 'PERCEPCIÓN VENTA INTERNA - TASA 2%',
			'2' => 'PERCEPCIÓN ADQUISICIÓN DE COMBUSTIBLE-TASA 1%',
			'3' => 'PERCEPCIÓN REALIZADA AL AGENTE DE PERCEPCIÓN CON TASA ESPECIAL - TASA 0.5%'
		],
		'tipo_de_nota_de_credito'=>[
			'' => 'Seleccionar',
			'1' => 'ANULACIÓN DE LA OPERACIÓN',
			'2' => 'ANULACIÓN POR ERROR EN EL RUC',
			'3' => 'CORRECCIÓN POR ERROR EN LA DESCRIPCIÓN',
			'4' => 'DESCUENTO GLOBAL',
			'5' => 'DESCUENTO POR ÍTEM',
			'6' => 'DEVOLUCIÓN TOTAL',
			'7' => 'DEVOLUCIÓN POR ÍTEM',
			'8' => 'BONIFICACIÓN',
			'9' => 'DISMINUCIÓN EN EL VALOR'
		],
		'tipo_de_nota_de_debito' => [
			'' => 'Seleccionar',
			'1' => 'INTERESES POR MORA',
			'2' => 'AUMENTO DE VALOR',
			'3' => 'PENALIDADES'
		],
		'unidad_de_medida' => [
			'' => 'Seleccionar',
			'NIU' => 'PRODUCTO',
			'ZZ' => 'SERVICIO'
		],
		'tipo_de_igv' => [
			'' => 'Seleccionar',
			'1' => 'Gravado - Operación Onerosa',
			'2' => 'Gravado – Retiro por premio',
			'3' => 'Gravado – Retiro por donación',
			'4' => 'Gravado – Retiro',
			'5' => 'Gravado – Retiro por publicidad',
			'6' => 'Gravado – Bonificaciones',
			'7' => 'Gravado – Retiro por entrega a trabajadores',
			'8' => 'Exonerado - Operación Onerosa',
			'9' => 'Inafecto - Operación Onerosa',
			'10' => 'Inafecto – Retiro por Bonificación',
			'11' => 'Inafecto – Retiro',
			'12' => 'Inafecto – Retiro por Muestras Médicas',
			'13' => 'Inafecto - Retiro por Convenio Colectivo',
			'14' => 'Inafecto – Retiro por premio',
			'15' => 'Inafecto - Retiro por publicidad',
			'16' => 'Exportación'
		],
		'guia_tipo' => [
			'' => 'Seleccionar',
			'1' => 'GUÍA DE REMISIÓN REMITENTE',
			'2' => 'GUÍA DE REMISIÓN TRANSPORTISTA'
		]

	],
	'icons' => [
		'store' => '<i class="fas fa-store"></i>',
		'view' => '<i class="fas fa-eye"></i>',
		'add' => '<i class="fas fa-plus"></i>',
		'edit' => '<i class="fas fa-pencil-alt"></i>',
		'remove' => '<i class="far fa-trash-alt"></i>',
		'email' => '<i class="far fa-envelope"></i>',
		'printer' => '<i class="fas fa-print"></i>',
		'pdf' => '<i class="fas fa-file-pdf"></i>',
		'list' => '<i class="fas fa-list"></i>',
		'more' => '<i class="fas fa-ellipsis-v"></i>',
		'credit-card' => '<i class="fas fa-credit-card"></i>',
		'pay' => '<i class="fab fa-cc-amazon-pay"></i>',
		'shopping' => '<i class="fas fa-shopping-cart"></i>',
		'file' => '<i class="fas fa-file-alt"></i>',
		'warning' => '<i class="fas fa-exclamation-triangle"></i>',
		'facebook' => '<i class="fab fa-facebook"></i>',
		'save' => '<i class="far fa-save"></i>',
		'search' => '<i class="fas fa-search"></i>',
		'shipping' => '<i class="fas fa-shipping-fast"></i>',
		'config' => '<i class="fas fa-cog"></i>',
		'history' => '<i class="fas fa-history"></i>',
		'check' => '<i class="fas fa-check"></i>',
		'external' => '<i class="fas fa-external-link-square-alt"></i>',
		'invoice' => '<i class="fas fa-file-invoice"></i>',
	],
	'bank_accounts' => [
		['label' => 'Cuenta Corriente Dólares Interbank',
			'number' => '631-3001268591',
			'cci' => '003-631-003001268591-90'
		],
		['label' => 'Cuenta Corriente Soles Interbank',
			'number' => '631-3001268584',
			'cci' => '003-631-003001268584-95'
		]
	],
//	'admin' => [
		'id_types' => [
			'index'  => ['panel'=>'Tipos de Documento', 'create'=>'Crear Tipo de Documento'],
			'create' => ['panel'=>'Nuevo Tipo de Documento:', 'create'=>'Crear Tipo de Documento'],
			'show'   => ['panel'=>'Vizualizando Tipo de Documento'],
			'edit'   => ['panel'=>'Editar Tipo de Documento: ', 'update'=>'Actualizar Tipo de Documento', 'delete'=>'Eliminar Tipo de Documento']
		],
		'unit_types' => [
			'index'  => ['panel'=>'Tipos de Unidad', 'create'=>'Crear Tipo de Unidad'],
			'create' => ['panel'=>'Nuevo Tipo de Unidad', 'create'=>'Crear Tipo de Unidad'],
			'show'   => ['panel'=>'Vizualizando Tipo de Unidad:'],
			'edit'   => ['panel'=>'Editar Tipo de Unidad: ', 'update'=>'Actualizar Tipo de Unidad', 'delete'=>'Eliminar Tipo de Unidad']
		],
		'currencies' => [
			'index'  => ['panel'=>'Monedas', 'create'=>'Crear Moneda'],
			'create' => ['panel'=>'Nueva Moneda', 'create'=>'Crear Moneda'],
			'show'   => ['panel'=>'Vizualizando Moneda:'],
			'edit'   => ['panel'=>'Editar Moneda: ', 'update'=>'Actualizar Moneda', 'delete'=>'Eliminar Moneda']
		],
		'document_types' => [
			'index'  => ['panel'=>'Tipos de Documento', 'create'=>'Crear Tipo de Documento'],
			'create' => ['panel'=>'Nueva Tipo de Documento:', 'create'=>'Crear Tipo de Documento'],
			'show'   => ['panel'=>'Vizualizando Tipo de Documento'],
			'edit'   => ['panel'=>'Editar Tipo de Documento: ', 'update'=>'Actualizar Tipo de Documento', 'delete'=>'Eliminar Tipo de Documento']
		],
		'document_controls' => [
			'index'  => ['panel'=>'Controles de Documento', 'create'=>'Crear Control de Documento'],
			'create' => ['panel'=>'Nueva Control de Documento:', 'create'=>'Crear Control de Documento'],
			'show'   => ['panel'=>'Vizualizando Control de Documento'],
			'edit'   => ['panel'=>'Editar Control de Documento: ', 'update'=>'Actualizar Control de Documento', 'delete'=>'Eliminar Control de Documento']
		],
	// ],
	// 'finances' => [
		'exchanges' => [
			'index'  => ['panel'=>'Tipo de Cambio', 'create'=>'Crear Tipo de Cambio'],
			'create' => ['panel'=>'Nuevo Tipo de Cambio:', 'create'=>'Crear Tipo de Cambio'],
			'show'   => ['panel'=>'Vizualizando Tipo de Cambio'],
			'edit'   => ['panel'=>'Editar Tipo de Cambio: ', 'update'=>'Actualizar Tipo de Cambio', 'delete'=>'Eliminar Tipo de Cambio']
		],
		'companies' => [
			'index'  => ['panel'=>'Empresas', 'create'=>'Crear Empresa'],
			'create' => ['panel'=>'Nueva Empresa', 'create'=>'Crear Empresa'],
			'show'   => ['panel'=>'Vizualizando Empresa:'],
			'edit'   => ['panel'=>'Editar Empresa: ', 'update'=>'Actualizar Empresa', 'delete'=>'Eliminar Empresa']
		],
		'payment_conditions' => [
			'index'  => ['panel'=>'Condiciones de Pago', 'create'=>'Crear Condición de Pago'],
			'create' => ['panel'=>'Nueva Condición de Pago', 'create'=>'Crear Condición de Pago'],
			'show'   => ['panel'=>'Vizualizando Condición de Pago:'],
			'edit'   => ['panel'=>'Editar Condición de Pago: ', 'update'=>'Actualizar Condición de Pago', 'delete'=>'Eliminar Condición de Pago']
		],
		'issuance_vouchers' => [
			'index'  => ['panel'=>'Comprobantes de Venta', 'create'=>'Crear Comprobante'],
			'create' => ['panel'=>'Nueva Comprobante de Venta', 'create'=>'Crear Comprobante de Venta'],
			'show'   => ['panel'=>'Vizualizando Comprobante de Venta:'],
			'edit'   => ['panel'=>'Editar Comprobante de Venta: ', 'update'=>'Actualizar Comprobante de Venta', 'delete'=>'Eliminar Comprobante de Venta']
		],
		'reception_vouchers' => [
			'index'  => ['panel'=>'Comprobantes de Compra', 'create'=>'Registrar Comprobante'],
			'create' => ['panel'=>'Nueva Comprobante de Compra', 'create'=>'Crear Comprobante de Compra'],
			'show'   => ['panel'=>'Vizualizando Comprobante de Compra:'],
			'edit'   => ['panel'=>'Editar Comprobante de Compra: ', 'update'=>'Actualizar Comprobante de Compra', 'delete'=>'Eliminar Comprobante de Compra']
		],
		'issuance_letters' => [
			'index'  => ['panel'=>'Letras Generadas', 'create'=>'Crear Letra'],
			'create' => ['panel'=>'Nueva Letra', 'create'=>'Crear Letra'],
			'show'   => ['panel'=>'Vizualizando Letra:'],
			'edit'   => ['panel'=>'Editar Letra: ', 'update'=>'Actualizar Letra', 'delete'=>'Eliminar Letra']
		],
		'reception_letters' => [
			'index'  => ['panel'=>'Letras Registradas', 'create'=>'Crear Letra'],
			'create' => ['panel'=>'Nueva Letra', 'create'=>'Crear Letra'],
			'show'   => ['panel'=>'Vizualizando Letra:'],
			'edit'   => ['panel'=>'Editar Letra: ', 'update'=>'Actualizar Letra', 'delete'=>'Eliminar Letra']
		],
		'issuance_swaps' => [
			'index'  => ['panel'=>'Canjes generados', 'create'=>'Crear Canje'],
			'create' => ['panel'=>'Nueva Canje', 'create'=>'Crear Canje'],
			'show'   => ['panel'=>'Vizualizando Canje:'],
			'edit'   => ['panel'=>'Editar Canje: ', 'update'=>'Actualizar Canje', 'delete'=>'Eliminar Canje']
		],
		'reception_swaps' => [
			'index'  => ['panel'=>'Canjes Registrados', 'create'=>'Registrar Canje'],
			'create' => ['panel'=>'Nueva Canje', 'create'=>'Registrar Canje'],
			'show'   => ['panel'=>'Vizualizando Canje:'],
			'edit'   => ['panel'=>'Editar Canje: ', 'update'=>'Actualizar Canje', 'delete'=>'Eliminar Canje']
		],
	// ],
	// 'autorepair' => [
		'checkitem_groups' => [
			'index'  => ['panel'=>'Grupo de Hoja Semaforo', 'create'=>'Crear Grupo'],
			'create' => ['panel'=>'Nuevo Grupo', 'create'=>'Crear Grupo'],
			'show'   => ['panel'=>'Vizualizando Grupo:'],
			'edit'   => ['panel'=>'Editar Grupo: ', 'update'=>'Actualizar Grupo', 'delete'=>'Eliminar Grupo']
		],
		'service_checklists' => [
			'index'  => ['panel'=>'Hojas Semáforo', 'create'=>'Crear Hoja Semáforo'],
			'create' => ['panel'=>'Nueva Hoja Semáforo', 'create'=>'Crear Hoja Semáforo'],
			'show'   => ['panel'=>'Vizualizando Hoja Semáforo:'],
			'edit'   => ['panel'=>'Editar Hoja Semáforo: ', 'update'=>'Actualizar Hoja Semáforo', 'delete'=>'Eliminar Hoja Semáforo']
		],
		'appointments' => [
			'index'  => ['panel'=>'Citas', 'create'=>'Crear Cita'],
			'create' => ['panel'=>'Nueva Cita', 'create'=>'Crear Cita'],
			'show'   => ['panel'=>'Vizualizando Cita:'],
			'edit'   => ['panel'=>'Editar Cita: ', 'update'=>'Actualizar Cita', 'delete'=>'Eliminar Cita']
		],
	// ],
	// 'humanresources' => [
		'employees' => [
			'index'  => ['panel'=>'Empleados', 'create'=>'Crear Empleado'],
			'create' => ['panel'=>'Nuevo Empleado', 'create'=>'Crear Empleado'],
			'show'   => ['panel'=>'Vizualizando Empleado:'],
			'edit'   => ['panel'=>'Editar Empleado: ', 'update'=>'Actualizar Empleado', 'delete'=>'Eliminar Empleado']
		],
		'jobs' => [
			'index'  => ['panel'=>'Cargos', 'create'=>'Crear Cargo'],
			'create' => ['panel'=>'Nuevo Cargo', 'create'=>'Crear Cargo'],
			'show'   => ['panel'=>'Vizualizando Cargo:'],
			'edit'   => ['panel'=>'Editar Cargo: ', 'update'=>'Actualizar Cargo', 'delete'=>'Eliminar Cargo']
		],
	// ],
	// 'logistics' => [
		'providers' => [
			'index'  => ['panel'=>'Proveedores', 'create'=>'Crear Proveedor'],
			'create' => ['panel'=>'Nueva Proveedor', 'create'=>'Crear Proveedor'],
			'show'   => ['panel'=>'Vizualizando Proveedor:'],
			'edit'   => ['panel'=>'Editar Proveedor: ', 'update'=>'Actualizar Proveedor', 'delete'=>'Eliminar Proveedor']
		],
		'brands' => [
			'index'  => ['panel'=>'Marcas', 'create'=>'Crear Marca'],
			'create' => ['panel'=>'Nueva Marca', 'create'=>'Crear Marca'],
			'show'   => ['panel'=>'Vizualizando Marca:'],
			'edit'   => ['panel'=>'Editar Marca: ', 'update'=>'Actualizar Marca', 'delete'=>'Eliminar Marca']
		],
		'purchases' => [
			'index'  => ['panel'=>'Compras', 'create'=>'Crear Compra'],
			'create' => ['panel'=>'Nueva Compra', 'create'=>'Crear Compra'],
			'show'   => ['panel'=>'Vizualizando Compra:'],
			'edit'   => ['panel'=>'Editar Compra: ', 'update'=>'Actualizar Compra', 'delete'=>'Eliminar Compra']
		],
	// ],
	// 'sales' => [
		'shippers' => [
			'index'  => ['panel'=>'Transportistas', 'create'=>'Crear Transportista'],
			'create' => ['panel'=>'Nueva Transportista', 'create'=>'Crear Transportista'],
			'show'   => ['panel'=>'Vizualizando Transportista:'],
			'edit'   => ['panel'=>'Editar Transportista: ', 'update'=>'Actualizar Transportista', 'delete'=>'Eliminar Transportista']
		],
		'clients' => [
			'index'  => ['panel'=>'Clientes', 'create'=>'Crear Cliente'],
			'create' => ['panel'=>'Nueva Cliente', 'create'=>'Crear Cliente'],
			'show'   => ['panel'=>'Vizualizando Cliente:'],
			'edit'   => ['panel'=>'Editar Cliente: ', 'update'=>'Actualizar Cliente', 'delete'=>'Eliminar Cliente']
		],
		'quotes' => [
			'index'  => ['panel'=>'Cotizaciones', 'create'=>'Crear Cotización'],
			'create' => ['panel'=>'Nuevo Cotización', 'create'=>'Crear Cotización'],
			'show'   => ['panel'=>'Vizualizando Cotización:'],
			'edit'   => ['panel'=>'Editar Cotización: ', 'update'=>'Actualizar Cotización', 'delete'=>'Eliminar Cotización']
		],
		'orders' => [
			'index'  => ['panel'=>'Pedidos', 'create'=>'Crear Pedido'],
			'create' => ['panel'=>'Nuevo Pedido', 'create'=>'Crear Pedido'],
			'show'   => ['panel'=>'Vizualizando Pedido:'],
			'edit'   => ['panel'=>'Editar Pedido: ', 'update'=>'Actualizar Pedido', 'delete'=>'Eliminar Pedido']
		],
	// ],
	// 'guard' => [
		'users' => [
			'index'  => ['panel'=>'Usuarios', 'create'=>'Crear Usuario'],
			'create' => ['panel'=>'Nuevo Usuario', 'create'=>'Crear Usuario'],
			'show'   => ['panel'=>'Vizualizando Usuario:'],
			'edit'   => ['panel'=>'Editar Usuario: ', 'update'=>'Actualizar Usuario', 'delete'=>'Eliminar Usuario']
		],
		'roles' => [
			'index'  => ['panel'=>'Roles', 'create'=>'Crear Rol'],
			'create' => ['panel'=>'Nuevo Rol', 'create'=>'Crear Rol'],
			'show'   => ['panel'=>'Vizualizando Rol:'],
			'edit'   => ['panel'=>'Editar Rol: ', 'update'=>'Actualizar Rol', 'delete'=>'Eliminar Rol']
		],
		'permissions' => [
			'index'  => ['panel'=>'Permisos', 'create'=>'Crear Permiso'],
			'create' => ['panel'=>'Nuevo Permiso', 'create'=>'Crear Permiso'],
			'show'   => ['panel'=>'Vizualizando Permiso:'],
			'edit'   => ['panel'=>'Editar Permiso: ', 'update'=>'Actualizar Permiso', 'delete'=>'Eliminar Permiso']
		],
		'permission_groups' => [
			'index'  => ['panel'=>'Grupos', 'create'=>'Crear Grupo'],
			'create' => ['panel'=>'Nuevo Grupo', 'create'=>'Crear Grupo'],
			'show'   => ['panel'=>'Vizualizando Grupo:'],
			'edit'   => ['panel'=>'Editar Grupo: ', 'update'=>'Actualizar Grupo', 'delete'=>'Eliminar Grupo']
		],
	// ],
	// 'storage' => [
		'units' => [
			'index'  => ['panel'=>'Unidades', 'create'=>'Crear Unidad'],
			'create' => ['panel'=>'Nueva Unidad', 'create'=>'Crear Unidad'],
			'show'   => ['panel'=>'Vizualizando Unidad:'],
			'edit'   => ['panel'=>'Editar Unidad: ', 'update'=>'Actualizar Unidad', 'delete'=>'Eliminar Unidad']
		],
		'warehouses' => [
			'index'  => ['panel'=>'Almacenes', 'create'=>'Crear Almacén'],
			'create' => ['panel'=>'Nuevo Almacén', 'create'=>'Crear Almacén'],
			'show'   => ['panel'=>'Vizualizando Almacén:'],
			'edit'   => ['panel'=>'Editar Almacén: ', 'update'=>'Actualizar Almacén', 'delete'=>'Eliminar Almacén']
		],
		'categories' => [
			'index'  => ['panel'=>'Categorías', 'create'=>'Crear Categoría'],
			'create' => ['panel'=>'Nueva Categoría', 'create'=>'Crear Categoría'],
			'show'   => ['panel'=>'Vizualizando Categoría:'],
			'edit'   => ['panel'=>'Editar Categoría: ', 'update'=>'Actualizar Categoría', 'delete'=>'Eliminar Categoría']
		],
		'sub_categories' => [
			'index'  => ['panel'=>'SubCategorías', 'create'=>'Crear SubCategoría'],
			'create' => ['panel'=>'Nueva SubCategoría', 'create'=>'Crear SubCategoría'],
			'show'   => ['panel'=>'Vizualizando SubCategoría:'],
			'edit'   => ['panel'=>'Editar SubCategoría: ', 'update'=>'Actualizar SubCategoría', 'delete'=>'Eliminar SubCategoría']
		],
		'products' => [
			'index'  => ['panel'=>'Productos', 'create'=>'Crear Producto'],
			'create' => ['panel'=>'Nuevo Producto', 'create'=>'Crear Producto'],
			'show'   => ['panel'=>'Vizualizando Producto:'],
			'edit'   => ['panel'=>'Editar Producto: ', 'update'=>'Actualizar Producto', 'delete'=>'Eliminar Producto']
		],
		'tickets' => [
			'index'  => ['panel'=>'Tickets', 'create'=>'Crear Ticket'],
			'create' => ['panel'=>'Nuevo Ticket', 'create'=>'Crear Ticket'],
			'show'   => ['panel'=>'Vizualizando Ticket:'],
			'edit'   => ['panel'=>'Editar Ticket: ', 'update'=>'Actualizar Ticket', 'delete'=>'Eliminar Ticket']
		],

	// ]

);
