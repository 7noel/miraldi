<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Security\User;
use App\Modules\Security\Role;
use App\Modules\Security\Permission;
use App\Modules\Security\PermissionGroup;
use App\Modules\Base\IdType;
use App\Modules\Base\UnitType;
use App\Modules\Storage\Unit;
use App\Modules\Base\Currency;
use App\Modules\Finances\Exchange;
use App\Modules\Finances\Company;
use App\Modules\Storage\Category;
use App\Modules\Storage\SubCategory;
use App\Modules\Storage\Product;
use App\Modules\Storage\Stock;
use App\Modules\Storage\ProductAccessory;
use App\Modules\Storage\Warehouse;
use App\Modules\Logistics\Brand;
use App\Modules\Base\DocumentType;
use App\Modules\Base\DocumentControl;
use App\Modules\Finances\PaymentCondition;
use App\Modules\Sales\Modelo;
use App\Modules\HumanResources\Job;
use App\Modules\HumanResources\Employee;
use App\Modules\Finances\Bank;

use Faker\Factory as Faker;

class AdminTableSeeder extends Seeder {

    public function run()
    {
        User::create(['name' => 'Noel', 'email' => 'noel.logan@gmail.com', 'password' => '123', 'is_superuser' => true]);
        User::create(['name' => 'JUAN MIRANDA', 'email' => 'juanmiranda@miraldi.com.pe', 'password' => '123', 'is_superuser' => true]);
        User::create(['name' => 'HUGO MIRANDA', 'email' => 'hugomiranda@miraldi.com.pe', 'password' => '123', 'is_superuser' => true]);
        User::create(['name' => 'NERIDA ESPINOZA', 'email' => 'neridaespinoza@miraldi.com.pe', 'password' => '123', 'is_superuser' => true]);
        User::create(['name' => 'YESENIA HUACCALLO', 'email' => 'yeseniahuaccallo@miraldi.com.pe', 'password' => '123', 'is_superuser' => true]);
        User::create(['name' => 'KARITO BECERRA', 'email' => 'karitobecerra@miraldi.com.pe', 'password' => '123', 'is_superuser' => true]);
        User::create(['name' => 'YESSICA INOÑAN', 'email' => 'yessicainonan@miraldi.com.pe', 'password' => '123', 'is_superuser' => true]);
        User::create(['name' => 'KATYA MORAN', 'email' => 'katyamoran@miraldi.com.pe', 'password' => '123', 'is_superuser' => true]);
        User::create(['name' => 'RANDI TUCTO', 'email' => 'randitucto@miraldi.com.pe', 'password' => '123', 'is_superuser' => true]);
        User::create(['name' => 'VICTOR LA ROSA', 'email' => 'victorlarosa@miraldi.com.pe', 'password' => '123', 'is_superuser' => true]);
        User::create(['name' => 'JOSEPH TUCTO', 'email' => 'joseptucto@miraldi.com.pe', 'password' => '123', 'is_superuser' => true]);
        User::create(['name' => 'DAVID ESPINOZA', 'email' => 'davidespinoza@miraldi.com.pe', 'password' => '123', 'is_superuser' => true]);

        Role::create(['name' => 'ADMINISTRADOR DE SISTEMA']);
        Role::create(['name' => 'GERENTE GENERAL']);
        Role::create(['name' => 'ADMINISTRADOR']);
        Role::create(['name' => 'ASISTENTE ADMINISTRATIVO']);
        Role::create(['name' => 'CREDITO Y FINANZAS']);
        Role::create(['name' => 'FACTURADOR']);
        Role::create(['name' => 'ASISTENTE CONTABLE']);
        Role::create(['name' => 'VENDEDOR']);

        // UserRole::create(['user_id' => 1, 'role_id' => 1]);
        // UserRole::create(['user_id' => 2, 'role_id' => 5]);
        // UserRole::create(['user_id' => 3, 'role_id' => 6]);
        // UserRole::create(['user_id' => 4, 'role_id' => 6]);
        // UserRole::create(['user_id' => 5, 'role_id' => 6]);
        // UserRole::create(['user_id' => 6, 'role_id' => 2]);
        // UserRole::create(['user_id' => 7, 'role_id' => 6]);
        // UserRole::create(['user_id' => 8, 'role_id' => 3]);
        // UserRole::create(['user_id' => 9, 'role_id' => 7]);
        //Role::create(['name' => 'JEFE DE ALMACEN']);
        //Role::create(['name' => 'ASISTENTE DE ALMACEN']);
        //Role::create(['name' => 'JEFE DE COMPRAS']);
        //Role::create(['name' => 'ASISTENTE DE ADV']);
        //Role::create(['name' => 'JEFE DE VENTAS']);
        //Role::create(['name' => 'RECEPCIONISTA']);

        IdType::create(['name' => 'REGISTRO UNICO DE CONTRIBUYENTE', 'symbol' => 'RUC', 'code' => '6']);
        IdType::create(['name' => 'DOCUMENTO NACIONAL DE IDENTIDAD', 'symbol' => 'DNI', 'code' => '1']);
        IdType::create(['name' => 'CARNET DE EXTRANJERÍA', 'symbol' => 'CEX', 'code' => '4']);
        IdType::create(['name' => 'PASAPORTE', 'symbol' => 'PAS', 'code' => '7']);
        IdType::create(['name' => 'CED. DIPLOMATICA DE IDENTIDAD', 'symbol' => 'CED', 'code' => 'A']);
        IdType::create(['name' => 'DOC.TRIB.NO.DOM.SIN.RUC', 'symbol' => 'NDO', 'code' => '0']);
        IdType::create(['name' => 'VARIOS', 'symbol' => 'S/D', 'code' => '-']);

        Job::create(['name' => 'ANALISTA DE SISTEMAS']);
        Job::create(['name' => 'GERENTE GENERAL']);
        Job::create(['name' => 'ADMINISTRADOR']);
        Job::create(['name' => 'ASISTENTE ADMINISTRATIVO']);
        Job::create(['name' => 'CREDITO Y FINANZAS']);
        Job::create(['name' => 'FACTURADOR']);
        Job::create(['name' => 'ASISTENTE CONTABLE']);
        Job::create(['name' => 'VENDEDOR']);

        Employee::create(['name' => 'NOEL', 'paternal_surname'=>'HUILLCA', 'maternal_surname'=>'HUAMANI', 'full_name'=>'HUILLCA HUAMANI NOEL', 'id_type_id'=>'2', 'doc'=>'44243484', 'job_id'=>'1', 'gender'=>'0', 'address'=>'JR. LAS GROSELLAS 910', 'ubigeo_id'=>'1306', 'user_id'=>'1', 'email_company' => '']);
        Employee::create(['name' => 'JUAN', 'paternal_surname'=>'MIRANDA', 'maternal_surname'=>'HUAMANI', 'full_name'=>'JUAN MIRANDA', 'id_type_id'=>'2', 'doc'=>'12345678', 'job_id'=>'2', 'gender'=>'0', 'address'=>'direccion', 'ubigeo_id'=>'1307', 'user_id'=>'2', 'email_company' => 'juanmiranda@miraldi.com.pe']);
        Employee::create(['name' => 'HUGO', 'paternal_surname'=>'MIRANDA', 'maternal_surname'=>'HUAMANI', 'full_name'=>'HUGO MIRANDA', 'id_type_id'=>'2', 'doc'=>'12345678', 'job_id'=>'3', 'gender'=>'0', 'address'=>'direccion', 'ubigeo_id'=>'1307', 'user_id'=>'3', 'email_company' => 'hugomiranda@miraldi.com.pe']);
        Employee::create(['name' => 'NERIDA', 'paternal_surname'=>'ESPINOZA', 'maternal_surname'=>'HUAMANI', 'full_name'=>'NERIDA ESPINOZA', 'id_type_id'=>'2', 'doc'=>'12345678', 'job_id'=>'4', 'gender'=>'0', 'address'=>'direccion', 'ubigeo_id'=>'1307', 'user_id'=>'4', 'email_company' => 'neridaespinoza@miraldi.com.pe']);
        Employee::create(['name' => 'YESENIA', 'paternal_surname'=>'HUACCALLO', 'maternal_surname'=>'HUAMANI', 'full_name'=>'YESENIA HUACCALLO', 'id_type_id'=>'2', 'doc'=>'12345678', 'job_id'=>'5', 'gender'=>'0', 'address'=>'direccion', 'ubigeo_id'=>'1307', 'user_id'=>'5', 'email_company' => 'yeseniahuaccallo@miraldi.com.pe']);
        Employee::create(['name' => 'KARITO', 'paternal_surname'=>'BECERRA', 'maternal_surname'=>'HUAMANI', 'full_name'=>'KARITO BECERRA', 'id_type_id'=>'2', 'doc'=>'12345678', 'job_id'=>'6', 'gender'=>'0', 'address'=>'direccion', 'ubigeo_id'=>'1307', 'user_id'=>'6', 'email_company' => 'karitobecerra@miraldi.com.pe']);
        Employee::create(['name' => 'YESSICA', 'paternal_surname'=>'INOÑAN', 'maternal_surname'=>'HUAMANI', 'full_name'=>'YESSICA INOÑAN', 'id_type_id'=>'2', 'doc'=>'12345678', 'job_id'=>'7', 'gender'=>'0', 'address'=>'direccion', 'ubigeo_id'=>'1307', 'user_id'=>'7', 'email_company' => 'yessicainonan@miraldi.com.pe']);
        Employee::create(['name' => 'KATYA', 'paternal_surname'=>'MORAN', 'maternal_surname'=>'HUAMANI', 'full_name'=>'KATYA MORAN', 'id_type_id'=>'2', 'doc'=>'12345678', 'job_id'=>'7', 'gender'=>'0', 'address'=>'direccion', 'ubigeo_id'=>'1307', 'user_id'=>'8', 'email_company' => 'katyamoran@miraldi.com.pe']);
        Employee::create(['name' => 'RANDI', 'paternal_surname'=>'TUCTO', 'maternal_surname'=>'HUAMANI', 'full_name'=>'RANDI TUCTO', 'id_type_id'=>'2', 'doc'=>'12345678', 'job_id'=>'8', 'gender'=>'0', 'address'=>'direccion', 'ubigeo_id'=>'1307', 'user_id'=>'9', 'email_company' => 'randitucto@miraldi.com.pe']);
        Employee::create(['name' => 'VICTOR', 'paternal_surname'=>'LA ROSA', 'maternal_surname'=>'HUAMANI', 'full_name'=>'VICTOR LA ROSA', 'id_type_id'=>'2', 'doc'=>'12345678', 'job_id'=>'8', 'gender'=>'0', 'address'=>'direccion', 'ubigeo_id'=>'1307', 'user_id'=>'10', 'email_company' => 'victorlarosa@miraldi.com.pe']);
        Employee::create(['name' => 'JOSEPH', 'paternal_surname'=>'TUCTO', 'maternal_surname'=>'HUAMANI', 'full_name'=>'JOSEPH TUCTO', 'id_type_id'=>'2', 'doc'=>'12345678', 'job_id'=>'8', 'gender'=>'0', 'address'=>'direccion', 'ubigeo_id'=>'1307', 'user_id'=>'11', 'email_company' => 'joseptucto@miraldi.com.pe']);
        Employee::create(['name' => 'DAVID', 'paternal_surname'=>'ESPINOZA', 'maternal_surname'=>'HUAMANI', 'full_name'=>'DAVID ESPINOZA', 'id_type_id'=>'2', 'doc'=>'12345678', 'job_id'=>'8', 'gender'=>'0', 'address'=>'direccion', 'ubigeo_id'=>'1307', 'user_id'=>'12', 'email_company' => 'davidespinoza@miraldi.com.pe']);



        Company::create(['company_name'=>'IMPORTACIONES MIRALDI S.A.C.', 'id_type_id'=>'1', 'doc'=>'20601787700', 'address'=>'AV. LAS VEGAS MZA. A LOTE. 19B URB. INDUSTRIAL (CRUCE AV PEDRO MIOTTA Y BELISARIO SUAREZ)', 'ubigeo_id'=>'1307', 'country_id' => 1465, 'is_my_company'=>1]);
        Company::create(['company_name'=>'HERRAMAX PERU E.I.R.L.', 'id_type_id'=>'1', 'doc'=>'20602227066', 'address'=>'JR. HUAROCHIRI NRO. 550 INT. 1025 (A UNA CUADRA DE LA PLAZA 2 DE MAYO)', 'ubigeo_id'=>'1275', 'country_id' => 1465, 'is_my_company'=>1]);
        Company::create(['company_name'=>'MIRALDI Y CIA. S.A.C.', 'id_type_id'=>'1', 'doc'=>'20501767540', 'address'=>'AV. LAS VEGAS MZA. A LOTE. 19-B (PEDRO MIOTA CON BELIZARIO)', 'ubigeo_id'=>'1307', 'country_id' => 1465, 'is_my_company'=>1]);



        PermissionGroup::create(['name' => 'SISTEMAS']);
        PermissionGroup::create(['name' => 'ADMINISTRACION']);
        PermissionGroup::create(['name' => 'ALMACEN']);
        PermissionGroup::create(['name' => 'LOGISTICA']);
        PermissionGroup::create(['name' => 'VENTAS']);
        PermissionGroup::create(['name' => 'FINANZAS']);
        PermissionGroup::create(['name' => 'RECURSOS HUMANOS']);
        PermissionGroup::create(['name' => 'PRODUCCION']);
        PermissionGroup::create(['name' => 'CONTABILIDAD']);

        // Usuarios
        Permission::create(['name' => 'Contraseña Editar', 'action' => 'change_password', 'permission_group_id' => 1]);
        Permission::create(['name' => 'Contraseña Actualizar', 'action' => 'update_password', 'permission_group_id' => 1]);
        Permission::create(['name' => 'Usuarios Listar', 'action' => 'users.index', 'permission_group_id' => 1]);
        Permission::create(['name' => 'Usuarios Ver', 'action' => 'users.show', 'permission_group_id' => 1]);
        Permission::create(['name' => 'Usuarios Crear', 'action' => 'users.create', 'permission_group_id' => 1]);
        Permission::create(['name' => 'Usuarios Editar', 'action' => 'users.edit', 'permission_group_id' => 1]);
        Permission::create(['name' => 'Usuarios Eliminar', 'action' => 'users.destroy', 'permission_group_id' => 1]);
        // Roles
        Permission::create(['name' => 'Roles Listar', 'action' => 'roles.index', 'permission_group_id' => 1]);
        Permission::create(['name' => 'Roles Ver', 'action' => 'roles.show', 'permission_group_id' => 1]);
        Permission::create(['name' => 'Roles Crear', 'action' => 'roles.create', 'permission_group_id' => 1]);
        Permission::create(['name' => 'Roles Editar', 'action' => 'roles.edit', 'permission_group_id' => 1]);
        Permission::create(['name' => 'Roles Eliminar', 'action' => 'roles.destroy', 'permission_group_id' => 1]);
        // Grupos
        Permission::create(['name' => 'Grupos Listar', 'action' => 'permission_groups.index', 'permission_group_id' => 1]);
        Permission::create(['name' => 'Grupos Ver', 'action' => 'permission_groups.show', 'permission_group_id' => 1]);
        Permission::create(['name' => 'Grupos Crear', 'action' => 'permission_groups.create', 'permission_group_id' => 1]);
        Permission::create(['name' => 'Grupos Editar', 'action' => 'permission_groups.edit', 'permission_group_id' => 1]);
        Permission::create(['name' => 'Grupos Eliminar', 'action' => 'permission_groups.destroy', 'permission_group_id' => 1]);
        // Permisos
        Permission::create(['name' => 'Permisos Listar', 'action' => 'permissions.index', 'permission_group_id' => 1]);
        Permission::create(['name' => 'Permisos Ver', 'action' => 'permissions.show', 'permission_group_id' => 1]);
        Permission::create(['name' => 'Permisos Crear', 'action' => 'permissions.create', 'permission_group_id' => 1]);
        Permission::create(['name' => 'Permisos Editar', 'action' => 'permissions.edit', 'permission_group_id' => 1]);
        Permission::create(['name' => 'Permisos Eliminar', 'action' => 'permissions.destroy', 'permission_group_id' => 1]);
        // Tipos de Unidad
        Permission::create(['name' => 'Tipos de Unidad Listar', 'action' => '.index', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Tipos de Unidad Ver', 'action' => '.show', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Tipos de Unidad Crear', 'action' => '.create', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Tipos de Unidad Editar', 'action' => '.edit', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Tipos de Unidad Eliminar', 'action' => '.destroy', 'permission_group_id' => 3]);
        // Unidad
        Permission::create(['name' => 'Unidad Listar', 'action' => '.index', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Unidad Ver', 'action' => '.show', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Unidad Crear', 'action' => '.create', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Unidad Editar', 'action' => '.edit', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Unidad Eliminar', 'action' => '.destroy', 'permission_group_id' => 3]);
        // Categorías
        Permission::create(['name' => 'Categorías Listar', 'action' => '.index', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Categorías Ver', 'action' => '.show', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Categorías Crear', 'action' => '.create', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Categorías Editar', 'action' => '.edit', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Categorías Eliminar', 'action' => '.destroy', 'permission_group_id' => 3]);
        // Sub Categorías
        Permission::create(['name' => 'Sub Categorías Listar', 'action' => '.index', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Sub Categorías Ver', 'action' => '.show', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Sub Categorías Crear', 'action' => '.create', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Sub Categorías Editar', 'action' => '.edit', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Sub Categorías Eliminar', 'action' => '.destroy', 'permission_group_id' => 3]);
        // Marcas
        Permission::create(['name' => 'Marcas Listar', 'action' => '.index', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Marcas Ver', 'action' => '.show', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Marcas Crear', 'action' => '.create', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Marcas Editar', 'action' => '.edit', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Marcas Eliminar', 'action' => '.destroy', 'permission_group_id' => 3]);
        // Almacenes
        Permission::create(['name' => 'Almacenes Listar', 'action' => '.index', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Almacenes Ver', 'action' => '.show', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Almacenes Crear', 'action' => '.create', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Almacenes Editar', 'action' => '.edit', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Almacenes Eliminar', 'action' => '.destroy', 'permission_group_id' => 3]);
        // Productos
        Permission::create(['name' => 'Productos Listar', 'action' => '.index', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Productos Ver', 'action' => '.show', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Productos Crear', 'action' => '.create', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Productos Editar', 'action' => '.edit', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Productos Eliminar', 'action' => '.destroy', 'permission_group_id' => 3]);
        // Tickets de E/S
        Permission::create(['name' => 'Tickets de E/S Listar', 'action' => '.index', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Tickets de E/S Ver', 'action' => '.show', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Tickets de E/S Crear', 'action' => '.create', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Tickets de E/S Editar', 'action' => '.edit', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Tickets de E/S Eliminar', 'action' => '.destroy', 'permission_group_id' => 3]);
        // Documentos Identidad
        Permission::create(['name' => 'Documentos Identidad Listar', 'action' => '.index', 'permission_group_id' => 2]);
        Permission::create(['name' => 'Documentos Identidad Ver', 'action' => '.show', 'permission_group_id' => 2]);
        Permission::create(['name' => 'Documentos Identidad Crear', 'action' => '.create', 'permission_group_id' => 2]);
        Permission::create(['name' => 'Documentos Identidad Editar', 'action' => '.edit', 'permission_group_id' => 2]);
        Permission::create(['name' => 'Documentos Identidad Eliminar', 'action' => '.destroy', 'permission_group_id' => 2]);
        // Empresas
        Permission::create(['name' => 'Empresas Listar', 'action' => '.index', 'permission_group_id' => 6]);
        Permission::create(['name' => 'Empresas Ver', 'action' => '.show', 'permission_group_id' => 6]);
        Permission::create(['name' => 'Empresas Crear', 'action' => '.create', 'permission_group_id' => 6]);
        Permission::create(['name' => 'Empresas Editar', 'action' => '.edit', 'permission_group_id' => 6]);
        Permission::create(['name' => 'Empresas Eliminar', 'action' => '.destroy', 'permission_group_id' => 6]);
        // Monedas
        Permission::create(['name' => 'Monedas Listar', 'action' => '.index', 'permission_group_id' => 6]);
        Permission::create(['name' => 'Monedas Ver', 'action' => '.show', 'permission_group_id' => 6]);
        Permission::create(['name' => 'Monedas Crear', 'action' => '.create', 'permission_group_id' => 6]);
        Permission::create(['name' => 'Monedas Editar', 'action' => '.edit', 'permission_group_id' => 6]);
        Permission::create(['name' => 'Monedas Eliminar', 'action' => '.destroy', 'permission_group_id' => 6]);
        // Documentos Comprobantes
        Permission::create(['name' => 'Documentos Comprobantes Listar', 'action' => '.index', 'permission_group_id' => 2]);
        Permission::create(['name' => 'Documentos Comprobantes Ver', 'action' => '.show', 'permission_group_id' => 2]);
        Permission::create(['name' => 'Documentos Comprobantes Crear', 'action' => '.create', 'permission_group_id' => 2]);
        Permission::create(['name' => 'Documentos Comprobantes Editar', 'action' => '.edit', 'permission_group_id' => 2]);
        Permission::create(['name' => 'Documentos Comprobantes Eliminar', 'action' => '.destroy', 'permission_group_id' => 2]);
        // Condiciones de Pago
        Permission::create(['name' => 'Condiciones de Pago Listar', 'action' => '.index', 'permission_group_id' => 6]);
        Permission::create(['name' => 'Condiciones de Pago Ver', 'action' => '.show', 'permission_group_id' => 6]);
        Permission::create(['name' => 'Condiciones de Pago Crear', 'action' => '.create', 'permission_group_id' => 6]);
        Permission::create(['name' => 'Condiciones de Pago Editar', 'action' => '.edit', 'permission_group_id' => 6]);
        Permission::create(['name' => 'Condiciones de Pago Eliminar', 'action' => '.destroy', 'permission_group_id' => 6]);
        // Tipos de Cambio
        Permission::create(['name' => 'Tipos de Cambio Listar', 'action' => '.index', 'permission_group_id' => 6]);
        Permission::create(['name' => 'Tipos de Cambio Ver', 'action' => '.show', 'permission_group_id' => 6]);
        Permission::create(['name' => 'Tipos de Cambio Crear', 'action' => '.create', 'permission_group_id' => 6]);
        Permission::create(['name' => 'Tipos de Cambio Editar', 'action' => '.edit', 'permission_group_id' => 6]);
        Permission::create(['name' => 'Tipos de Cambio Eliminar', 'action' => '.destroy', 'permission_group_id' => 6]);
        // Cargos
        Permission::create(['name' => 'Cargos Listar', 'action' => '.index', 'permission_group_id' => 7]);
        Permission::create(['name' => 'Cargos Ver', 'action' => '.show', 'permission_group_id' => 7]);
        Permission::create(['name' => 'Cargos Crear', 'action' => '.create', 'permission_group_id' => 7]);
        Permission::create(['name' => 'Cargos Editar', 'action' => '.edit', 'permission_group_id' => 7]);
        Permission::create(['name' => 'Cargos Eliminar', 'action' => '.destroy', 'permission_group_id' => 7]);
        // Empleados
        Permission::create(['name' => 'Empleados Listar', 'action' => '.index', 'permission_group_id' => 7]);
        Permission::create(['name' => 'Empleados Ver', 'action' => '.show', 'permission_group_id' => 7]);
        Permission::create(['name' => 'Empleados Crear', 'action' => '.create', 'permission_group_id' => 7]);
        Permission::create(['name' => 'Empleados Editar', 'action' => '.edit', 'permission_group_id' => 7]);
        Permission::create(['name' => 'Empleados Eliminar', 'action' => '.destroy', 'permission_group_id' => 7]);
        // Cotizaciones orders
        Permission::create(['name' => 'Cotizaciones Listar', 'action' => '.index', 'permission_group_id' => 5]);
        Permission::create(['name' => 'Cotizaciones Ver', 'action' => '.show', 'permission_group_id' => 5]);
        Permission::create(['name' => 'Cotizaciones Crear', 'action' => '.create', 'permission_group_id' => 5]);
        Permission::create(['name' => 'Cotizaciones Editar', 'action' => '.edit', 'permission_group_id' => 5]);
        Permission::create(['name' => 'Cotizaciones Eliminar', 'action' => '.destroy', 'permission_group_id' => 5]);
        // Compras
        Permission::create(['name' => 'Compras Listar', 'action' => '.index', 'permission_group_id' => 4]);
        Permission::create(['name' => 'Compras Ver', 'action' => '.show', 'permission_group_id' => 4]);
        Permission::create(['name' => 'Compras Crear', 'action' => '.create', 'permission_group_id' => 4]);
        Permission::create(['name' => 'Compras Editar', 'action' => '.edit', 'permission_group_id' => 4]);
        Permission::create(['name' => 'Compras Eliminar', 'action' => '.destroy', 'permission_group_id' => 4]);
        // // Control de Documentos
        // Permission::create(['name' => 'Control de Documentos Listar', 'action' => '.index', 'permission_group_id' => '4']);
        // Permission::create(['name' => 'Control de Documentos Ver', 'action' => '.show', 'permission_group_id' => '4']);
        // Permission::create(['name' => 'Control de Documentos Crear', 'action' => '.create', 'permission_group_id' => '4']);
        // Permission::create(['name' => 'Control de Documentos Editar', 'action' => '.edit', 'permission_group_id' => '4']);
        // Permission::create(['name' => 'Control de Documentos Eliminar', 'action' => '.destroy', 'permission_group_id' => '4']);
        // // Medios de Pago
        // Permission::create(['name' => 'Medios de Pago Listar', 'action' => '.index', 'permission_group_id' => '4']);
        // Permission::create(['name' => 'Medios de Pago Ver', 'action' => '.show', 'permission_group_id' => '4']);
        // Permission::create(['name' => 'Medios de Pago Crear', 'action' => '.create', 'permission_group_id' => '4']);
        // Permission::create(['name' => 'Medios de Pago Editar', 'action' => '.edit', 'permission_group_id' => '4']);
        // Permission::create(['name' => 'Medios de Pago Eliminar', 'action' => '.destroy', 'permission_group_id' => '4']);



        DocumentType::create(['name' => 'FACTURA', 'code' => '1', 'to_sales' => '1', 'to_purchases' => '1']);
        DocumentType::create(['name' => 'BOLETA', 'code' => '2', 'to_sales' => '1']);
        DocumentType::create(['name' => 'NOTA DE CRÉDITO', 'code' => '3', 'to_sales' => '1', 'to_purchases' => '1']);
        DocumentType::create(['name' => 'NOTA DE DÉBITO', 'code' => '4', 'to_sales' => '1', 'to_purchases' => '1']);
        DocumentType::create(['name' => 'INVOICE', 'code' => '91', 'to_purchases' => '1']);
        DocumentType::create(['name' => 'OT', 'code' => '00']);
        DocumentType::create(['name' => 'TK', 'code' => '00']);

        DocumentControl::create(['document_type_id' => 1, 'company_id' => 1, 'series'=>'F001', 'number'=>0]);
        DocumentControl::create(['document_type_id' => 2, 'company_id' => 1, 'series'=>'B001', 'number'=>0]);
        DocumentControl::create(['document_type_id' => 3, 'company_id' => 1, 'series'=>'FC01', 'number'=>0]);
        DocumentControl::create(['document_type_id' => 3, 'company_id' => 1, 'series'=>'BC01', 'number'=>0]);
        DocumentControl::create(['document_type_id' => 4, 'company_id' => 1, 'series'=>'FD01', 'number'=>0]);
        DocumentControl::create(['document_type_id' => 4, 'company_id' => 1, 'series'=>'BD01', 'number'=>0]);

        DocumentControl::create(['document_type_id' => 1, 'company_id' => 2, 'series'=>'F001', 'number'=>0]);
        DocumentControl::create(['document_type_id' => 2, 'company_id' => 2, 'series'=>'B001', 'number'=>0]);
        DocumentControl::create(['document_type_id' => 3, 'company_id' => 2, 'series'=>'FC01', 'number'=>0]);
        DocumentControl::create(['document_type_id' => 3, 'company_id' => 2, 'series'=>'BC01', 'number'=>0]);
        DocumentControl::create(['document_type_id' => 4, 'company_id' => 2, 'series'=>'FD01', 'number'=>0]);
        DocumentControl::create(['document_type_id' => 4, 'company_id' => 2, 'series'=>'BD01', 'number'=>0]);

        DocumentControl::create(['document_type_id' => 1, 'company_id' => 3, 'series'=>'F001', 'number'=>0]);
        DocumentControl::create(['document_type_id' => 2, 'company_id' => 3, 'series'=>'B001', 'number'=>0]);
        DocumentControl::create(['document_type_id' => 3, 'company_id' => 3, 'series'=>'FC01', 'number'=>0]);
        DocumentControl::create(['document_type_id' => 3, 'company_id' => 3, 'series'=>'BC01', 'number'=>0]);
        DocumentControl::create(['document_type_id' => 4, 'company_id' => 3, 'series'=>'FD01', 'number'=>0]);
        DocumentControl::create(['document_type_id' => 4, 'company_id' => 3, 'series'=>'BD01', 'number'=>0]);

        PaymentCondition::create(['name' => 'CONTADO', 'to_sales' => '1', 'to_purchases' => '1']);
        PaymentCondition::create(['name' => 'CRÉDITO', 'to_sales' => '1', 'to_purchases' => '1']);
        
        UnitType::create(['name' => 'UNIDAD']);
        UnitType::create(['name' => 'LONGITUD']);
        UnitType::create(['name' => 'VOLUMEN']);
        UnitType::create(['name' => 'MASA']);

        Unit::create(['name' => 'UNIDAD', 'symbol' => 'und', 'unit_type_id' => 1, 'value' => 1, 'code' => 'NIU']); // 1
        Unit::create(['name' => 'PARES', 'symbol' => 'prs', 'unit_type_id' => 1, 'value' => 2, 'code' => 'NIU']); // 2
        Unit::create(['name' => 'DECENA', 'symbol' => 'dec', 'unit_type_id' => 1, 'value' => 10, 'code' => 'NIU']); // 3
        Unit::create(['name' => 'CIENTO', 'symbol' => 'cto', 'unit_type_id' => 1, 'value' => 100, 'code' => 'NIU']); // 4
        Unit::create(['name' => 'GRUEZA', 'symbol' => 'dec', 'unit_type_id' => 1, 'value' => 1728, 'code' => 'NIU']); // 5
        Unit::create(['name' => 'MILLAR', 'symbol' => 'mill', 'unit_type_id' => 1, 'value' => 1000, 'code' => 'NIU']); // 6

        Unit::create(['name' => 'SET', 'symbol' => 'set', 'unit_type_id' => 1, 'value' => 1728, 'code' => 'NIU']); // 7
        Unit::create(['name' => 'METRO', 'symbol' => 'mt', 'unit_type_id' => 4, 'value' => 1, 'code' => 'NIU']); // 8
        Unit::create(['name' => 'KILOGRAMO', 'symbol' => 'kg', 'unit_type_id' => 2, 'value' => 1, 'code' => 'NIU']); // 9


        // Unit::create(['name' => 'CENTIMETRO', 'symbol' => 'cm', 'unit_type_id' => 4, 'value' => 1, 'code' => '']);
        // Unit::create(['name' => 'KILOMETRO', 'symbol' => 'km', 'unit_type_id' => 4, 'value' => 100000, 'code' => '']);
        // Unit::create(['name' => 'PULGADA', 'symbol' => 'pulg', 'unit_type_id' => 4, 'value' => 2.54, 'code' => '']);
        // Unit::create(['name' => 'PIE', 'symbol' => 'pie', 'unit_type_id' => 4, 'value' => 30.48, 'code' => '']);
        // Unit::create(['name' => 'YARDA', 'symbol' => 'yar', 'unit_type_id' => 4, 'value' => 91.44, 'code' => '']);
        // Unit::create(['name' => 'MILLA', 'symbol' => 'milla', 'unit_type_id' => 4, 'value' => 160934, 'code' => '']);
        // Unit::create(['name' => 'MILILITRO', 'symbol' => 'ml', 'unit_type_id' => 2, 'value' => 1, 'code' => '']);
        // Unit::create(['name' => 'LITRO', 'symbol' => 'lt', 'unit_type_id' => 2, 'value' => 1000, 'code' => '08']);
        // Unit::create(['name' => 'METRO CUBICO', 'symbol' => 'm3', 'unit_type_id' => 2, 'value' => 1000000, 'code' => '']);
        // Unit::create(['name' => 'PULGADA CUBICA', 'symbol' => 'pulg3', 'unit_type_id' => 2, 'value' => 16.3871, 'code' => '']);
        // Unit::create(['name' => 'PIE CUBICO', 'symbol' => 'pie3', 'unit_type_id' => 2, 'value' => 28317, 'code' => '']);
        // Unit::create(['name' => 'GALON', 'symbol' => 'gal', 'unit_type_id' => 2, 'value' => 3785.4, 'code' => '09']);
        // Unit::create(['name' => 'GRAMO', 'symbol' => 'gr', 'unit_type_id' => 3, 'value' => 1, 'code' => '06']);
        // Unit::create(['name' => 'TONELADA', 'symbol' => 'ton', 'unit_type_id' => 3, 'value' => 1000000, 'code' => '04']);
        // Unit::create(['name' => 'ONZA', 'symbol' => 'oz', 'unit_type_id' => 3, 'value' => 28.349, 'code' => '']);
        // Unit::create(['name' => 'LIBRA', 'symbol' => 'lb', 'unit_type_id' => 3, 'value' => 453.59, 'code' => '02']);

        Currency::create(['name' => 'SOLES', 'symbol' => 'S/', 'code' => '1']);
        Currency::create(['name' => 'DOLARES AMERICANOS', 'symbol' => 'US$', 'code' => '2']);
        // Currency::create(['name' => 'EUROS', 'symbol' => '€', 'code' => '3']);

        Exchange::create(['date' => date('Y-m-d'), 'currency_id' => 1, 'sales' => 3, 'purchase' => 3]);

        Category::create(['name' => 'PRODUCTO FINAL', 'code' => '01']);
        Category::create(['name' => 'ACCESORIOS', 'code' => '01']);
        // Category::create(['name' => 'PRODUCTO TERMINADO', 'code' => '02']);
        // Category::create(['name' => 'MATERIA PRIMA', 'code' => '03']);
        // Category::create(['name' => 'ENVASES Y EMBALAJES', 'code' => '04']);
        // Category::create(['name' => 'SUMINISTROS DIVERSOS', 'code' => '05']);
        // Category::create(['name' => 'HERRAMIENTAS', 'code' => '']);
        // Category::create(['name' => 'SERVICIOS', 'code' => '']);

        SubCategory::create(['name' => 'AUTOMOTRIZ', 'category_id' => 1]);
        SubCategory::create(['name' => 'CERRAJERIA PARA MADERA Y VIDRIO', 'category_id' => 1]);
        SubCategory::create(['name' => 'ELECTRONICA', 'category_id' => 1]);
        SubCategory::create(['name' => 'GASFITERIA', 'category_id' => 1]);
        SubCategory::create(['name' => 'GENERICOS', 'category_id' => 1]);
        SubCategory::create(['name' => 'ILUMINACION Y ELECTRICIDAD', 'category_id' => 1]);
        SubCategory::create(['name' => 'INTERNO', 'category_id' => 1]);
        SubCategory::create(['name' => 'MAQUINARIAS, HERRAMIENTAS Y REPUESTOS', 'category_id' => 1]);
        SubCategory::create(['name' => 'MATERIALES Y ACABADOS DE CONSTRUCCION', 'category_id' => 1]);
        SubCategory::create(['name' => 'SEGURIDAD INDUSTRIAL Y PROTECCION PERSONAL', 'category_id' => 1]);


        Brand::create(['name' => 'ADVANCED', 'is_car' => '0']);
        Brand::create(['name' => 'EUROCOLUMBUS', 'is_car' => '0']);
        Brand::create(['name' => 'FAMED LODZ', 'is_car' => '0']);
        Brand::create(['name' => 'FAMED ZYWIEC', 'is_car' => '0']);
        Brand::create(['name' => 'GMM', 'is_car' => '0']);
        Brand::create(['name' => 'HERSILL', 'is_car' => '0']);
        Brand::create(['name' => 'NEUMOVENT', 'is_car' => '0']);
        Brand::create(['name' => 'PROHS', 'is_car' => '0']);
        Brand::create(['name' => 'TSE', 'is_car' => '0']);
        Brand::create(['name' => 'ZOLL', 'is_car' => '0']);

        Warehouse::create(['name' => 'ALMACEN IMPORTACIONES', 'ubigeo_id' => 1309, 'address' => 'DIRECCION']);
        Warehouse::create(['name' => 'ALMACEN HERRAMAX', 'ubigeo_id' => 1309, 'address' => 'DIRECCION']);
        Warehouse::create(['name' => 'ALMACEN MIRALDI', 'ubigeo_id' => 1309, 'address' => 'DIRECCION']);


        Bank::create(['label' => 'HERRAMAX BCP SOLES', 'number' => '194-2438503-0-42', 'CCI' => '', 'company_id' => 2, 'currency_id' => 1, 'value' => 0]);
        Bank::create(['label' => 'IMPORTACIONES BCP SOLES', 'number' => '194-2386744-0-23', 'CCI' => '', 'company_id' => 2, 'currency_id' => 1, 'value' => 0]);
        Bank::create(['label' => 'IMPORTACIONES BCP DOLARES', 'number' => '194-2394196-1-06', 'CCI' => '', 'company_id' => 2, 'currency_id' => 2, 'value' => 0]);
        Bank::create(['label' => 'MIRALDI BCP SOLES', 'number' => '194-2447511-0-32', 'CCI' => '', 'company_id' => 2, 'currency_id' => 1, 'value' => 0]);
        Bank::create(['label' => 'MIRALDI BCP DOLARES', 'number' => '194-2441216-1-56', 'CCI' => '', 'company_id' => 2, 'currency_id' => 2, 'value' => 0]);
        Bank::create(['label' => 'MIRALDI BCP SOLES AHORROS', 'number' => '194-38124038-0-28', 'CCI' => '', 'company_id' => 2, 'currency_id' => 1, 'value' => 0]);

    }
}