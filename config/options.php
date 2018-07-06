<?php 
return array(
	'product_status' => [
		''=>'Status',
		'1'=>'Activo',
		'3'=>'A pedido',
		'2'=>'Inactivo'
	],
	'mov' => [
		'' => 'Seleccionar',
		'1' => 'Entrada',
		'0' => 'Salida',
	],
	'purchase_status' => [],
	'order_status' => ['REGISTRADO', 'VERIFICADO', 'APROBADO', 'FACTURADO', 'ENVIADO', 'CANCELADO'],
	'tax' => [
		'igv' => 18
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
		'external' => '<i class="fas fa-external-link-square-alt"></i>'
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
		'orders' => [
			'index'  => ['panel'=>'Cotizaciones', 'create'=>'Crear Cotización'],
			'create' => ['panel'=>'Nuevo Cotización', 'create'=>'Crear Cotización'],
			'show'   => ['panel'=>'Vizualizando Cotización:'],
			'edit'   => ['panel'=>'Editar Cotización: ', 'update'=>'Actualizar Cotización', 'delete'=>'Eliminar Cotización']
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
