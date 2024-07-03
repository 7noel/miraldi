<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;
//use App\Modules\Base\Table;
use App\Role;
use App\PermissionGroup;
use App\Permission;

use Faker\Factory as Faker;

class AdminTableSeeder extends Seeder {

    public function run()
    {

        Role::create(['name' => 'ADMINISTRADOR']);
        Role::create(['name' => 'VENDEDOR']);
        Role::create(['name' => 'ALMACEN']);

        User::create(['name' => 'Noel', 'email' => 'noel.logan@gmail.com', 'password' => '44243484', 'role_id' => 1, 'user_code' => 'VEND30', 'seller_code' => 30]);
        User::create(['name' => 'EDGAR HUGO MIRANDA ALARCON', 'email' => 'hugomiranda@miraldi.com.pe', 'password' => '20658438', 'role_id' => 2, 'user_code' => 'VEND10', 'seller_code' => 10]);
        User::create(['name' => 'LOIDA EUNICE GALLARDO RIVERA', 'email' => 'vend18@miraldi.com.pe', 'password' => '70218177', 'role_id' => 2, 'user_code' => 'VEND18', 'seller_code' => 18]);
        User::create(['name' => 'VICTOR ALEJANDRO LA ROSA SALGU', 'email' => 'vend20@miraldi.com.pe', 'password' => '41720001', 'role_id' => 2, 'user_code' => 'VEND20', 'seller_code' => 20]);
        User::create(['name' => 'JOSEPH DANTANA TUCTO POLONIO', 'email' => 'vend60@miraldi.com.pe', 'password' => '43058658', 'role_id' => 2, 'user_code' => 'VEND60', 'seller_code' => 60]);
        User::create(['name' => 'RANDI PAUL TUCTO POLONIO', 'email' => 'vend67@miraldi.com.pe', 'password' => '44140029', 'role_id' => 2, 'user_code' => 'VEND67', 'seller_code' => 67]);
        User::create(['name' => 'DAVID ESPINOZA CASAS', 'email' => 'vend88@miraldi.com.pe', 'password' => '40218951', 'role_id' => 2, 'user_code' => 'VEND88', 'seller_code' => 88]);
        User::create(['name' => 'JOSUE VEGA BERNAL', 'email' => 'vend91@miraldi.com.pe', 'password' => '46955199', 'role_id' => 2, 'user_code' => 'VEND91', 'seller_code' => 91]);
        User::create(['name' => 'KARITO BECERRA', 'email' => 'karitobecerra@miraldi.com.pe', 'password' => 'contraseña', 'role_id' => 2, 'user_code' => 'VEND30', 'seller_code' => 30]);
        User::create(['name' => 'ALMACEN', 'email' => 'almacen@miraldi.com.pe', 'password' => 'miraldi', 'role_id' => 3, 'user_code' => '1', 'seller_code' => 30]);

/*
        PermissionGroup::create(['name' => 'SISTEMAS']);
        PermissionGroup::create(['name' => 'ADMINISTRACION']);
        PermissionGroup::create(['name' => 'ALMACEN']);
        PermissionGroup::create(['name' => 'LOGISTICA']);
        PermissionGroup::create(['name' => 'VENTAS']);
        PermissionGroup::create(['name' => 'FINANZAS']);
        PermissionGroup::create(['name' => 'RECURSOS HUMANOS']);
        PermissionGroup::create(['name' => 'PRODUCCION']);
        PermissionGroup::create(['name' => 'CONTABILIDAD']);

        Role::create(['my_company' => '1', 'name' => 'ADMINISTRADOR DE SISTEMA']);
        Role::create(['my_company' => '1', 'name' => 'GERENTE GENERAL']);
        Role::create(['my_company' => '1', 'name' => 'ADMINISTRADOR']);
        Role::create(['my_company' => '1', 'name' => 'ASISTENTE ADMINISTRATIVO']);
        Role::create(['my_company' => '1', 'name' => 'CREDITO Y FINANZAS']);
        Role::create(['my_company' => '1', 'name' => 'FACTURADOR']);
        Role::create(['my_company' => '1', 'name' => 'ASISTENTE CONTABLE']);
        Role::create(['my_company' => '1', 'name' => 'VENDEDOR']);

        // 2117 es el ultimo id de table (después de cargar ubigeo y paises)

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
        Permission::create(['name' => 'Tipos de Unidad Listar', 'action' => 'unit_types.index', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Tipos de Unidad Ver', 'action' => 'unit_types.show', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Tipos de Unidad Crear', 'action' => 'unit_types.create', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Tipos de Unidad Editar', 'action' => 'unit_types.edit', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Tipos de Unidad Eliminar', 'action' => 'unit_types.destroy', 'permission_group_id' => 3]);
        // Unidad
        Permission::create(['name' => 'Unidad Listar', 'action' => 'units.index', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Unidad Ver', 'action' => 'units.show', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Unidad Crear', 'action' => 'units.create', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Unidad Editar', 'action' => 'units.edit', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Unidad Eliminar', 'action' => 'units.destroy', 'permission_group_id' => 3]);
        // Categorías
        Permission::create(['name' => 'Categorías Listar', 'action' => 'categories.index', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Categorías Ver', 'action' => 'categories.show', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Categorías Crear', 'action' => 'categories.create', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Categorías Editar', 'action' => 'categories.edit', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Categorías Eliminar', 'action' => 'categories.destroy', 'permission_group_id' => 3]);
        // Sub Categorías
        Permission::create(['name' => 'Sub Categorías Listar', 'action' => 'sub_categories.index', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Sub Categorías Ver', 'action' => 'sub_categories.show', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Sub Categorías Crear', 'action' => 'sub_categories.create', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Sub Categorías Editar', 'action' => 'sub_categories.edit', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Sub Categorías Eliminar', 'action' => 'sub_categories.destroy', 'permission_group_id' => 3]);
        // Marcas
        Permission::create(['name' => 'Marcas Listar', 'action' => 'brands.index', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Marcas Ver', 'action' => 'brands.show', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Marcas Crear', 'action' => 'brands.create', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Marcas Editar', 'action' => 'brands.edit', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Marcas Eliminar', 'action' => 'brands.destroy', 'permission_group_id' => 3]);
        // Almacenes
        Permission::create(['name' => 'Almacenes Listar', 'action' => 'warehouses.index', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Almacenes Ver', 'action' => 'warehouses.show', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Almacenes Crear', 'action' => 'warehouses.create', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Almacenes Editar', 'action' => 'warehouses.edit', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Almacenes Eliminar', 'action' => 'warehouses.destroy', 'permission_group_id' => 3]);
        // Productos
        Permission::create(['name' => 'Productos Listar', 'action' => 'products.index', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Productos Ver', 'action' => 'products.show', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Productos Crear', 'action' => 'products.create', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Productos Editar', 'action' => 'products.edit', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Productos Eliminar', 'action' => 'products.destroy', 'permission_group_id' => 3]);
        // Tickets de E/S
        Permission::create(['name' => 'Tickets de E/S Listar', 'action' => 'tickets.index', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Tickets de E/S Ver', 'action' => 'tickets.show', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Tickets de E/S Crear', 'action' => 'tickets.create', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Tickets de E/S Editar', 'action' => 'tickets.edit', 'permission_group_id' => 3]);
        Permission::create(['name' => 'Tickets de E/S Eliminar', 'action' => 'tickets.destroy', 'permission_group_id' => 3]);
        // Documentos Identidad
        Permission::create(['name' => 'Documentos Identidad Listar', 'action' => 'id_types.index', 'permission_group_id' => 2]);
        Permission::create(['name' => 'Documentos Identidad Ver', 'action' => 'id_types.show', 'permission_group_id' => 2]);
        Permission::create(['name' => 'Documentos Identidad Crear', 'action' => 'id_types.create', 'permission_group_id' => 2]);
        Permission::create(['name' => 'Documentos Identidad Editar', 'action' => 'id_types.edit', 'permission_group_id' => 2]);
        Permission::create(['name' => 'Documentos Identidad Eliminar', 'action' => 'id_types.destroy', 'permission_group_id' => 2]);
        // Empresas
        Permission::create(['name' => 'Empresas Listar', 'action' => 'companies.index', 'permission_group_id' => 6]);
        Permission::create(['name' => 'Empresas Ver', 'action' => 'companies.show', 'permission_group_id' => 6]);
        Permission::create(['name' => 'Empresas Crear', 'action' => 'companies.create', 'permission_group_id' => 6]);
        Permission::create(['name' => 'Empresas Editar', 'action' => 'companies.edit', 'permission_group_id' => 6]);
        Permission::create(['name' => 'Empresas Eliminar', 'action' => 'companies.destroy', 'permission_group_id' => 6]);
        // Monedas
        Permission::create(['name' => 'Monedas Listar', 'action' => 'currencies.index', 'permission_group_id' => 6]);
        Permission::create(['name' => 'Monedas Ver', 'action' => 'currencies.show', 'permission_group_id' => 6]);
        Permission::create(['name' => 'Monedas Crear', 'action' => 'currencies.create', 'permission_group_id' => 6]);
        Permission::create(['name' => 'Monedas Editar', 'action' => 'currencies.edit', 'permission_group_id' => 6]);
        Permission::create(['name' => 'Monedas Eliminar', 'action' => 'currencies.destroy', 'permission_group_id' => 6]);
        // Documentos Comprobantes
        Permission::create(['name' => 'Documentos Comprobantes Listar', 'action' => 'document_types.index', 'permission_group_id' => 2]);
        Permission::create(['name' => 'Documentos Comprobantes Ver', 'action' => 'document_types.show', 'permission_group_id' => 2]);
        Permission::create(['name' => 'Documentos Comprobantes Crear', 'action' => 'document_types.create', 'permission_group_id' => 2]);
        Permission::create(['name' => 'Documentos Comprobantes Editar', 'action' => 'document_types.edit', 'permission_group_id' => 2]);
        Permission::create(['name' => 'Documentos Comprobantes Eliminar', 'action' => 'document_types.destroy', 'permission_group_id' => 2]);
        // Condiciones de Pago
        Permission::create(['name' => 'Condiciones de Pago Listar', 'action' => 'payment_conditions.index', 'permission_group_id' => 6]);
        Permission::create(['name' => 'Condiciones de Pago Ver', 'action' => 'payment_conditions.show', 'permission_group_id' => 6]);
        Permission::create(['name' => 'Condiciones de Pago Crear', 'action' => 'payment_conditions.create', 'permission_group_id' => 6]);
        Permission::create(['name' => 'Condiciones de Pago Editar', 'action' => 'payment_conditions.edit', 'permission_group_id' => 6]);
        Permission::create(['name' => 'Condiciones de Pago Eliminar', 'action' => 'payment_conditions.destroy', 'permission_group_id' => 6]);
        // Tipos de Cambio
        Permission::create(['name' => 'Tipos de Cambio Listar', 'action' => 'exchanges.index', 'permission_group_id' => 6]);
        Permission::create(['name' => 'Tipos de Cambio Ver', 'action' => 'exchanges.show', 'permission_group_id' => 6]);
        Permission::create(['name' => 'Tipos de Cambio Crear', 'action' => 'exchanges.create', 'permission_group_id' => 6]);
        Permission::create(['name' => 'Tipos de Cambio Editar', 'action' => 'exchanges.edit', 'permission_group_id' => 6]);
        Permission::create(['name' => 'Tipos de Cambio Eliminar', 'action' => 'exchanges.destroy', 'permission_group_id' => 6]);
        // Cargos
        Permission::create(['name' => 'Cargos Listar', 'action' => 'jobs.index', 'permission_group_id' => 7]);
        Permission::create(['name' => 'Cargos Ver', 'action' => 'jobs.show', 'permission_group_id' => 7]);
        Permission::create(['name' => 'Cargos Crear', 'action' => 'jobs.create', 'permission_group_id' => 7]);
        Permission::create(['name' => 'Cargos Editar', 'action' => 'jobs.edit', 'permission_group_id' => 7]);
        Permission::create(['name' => 'Cargos Eliminar', 'action' => 'jobs.destroy', 'permission_group_id' => 7]);
        // Empleados
        Permission::create(['name' => 'Empleados Listar', 'action' => 'employees.index', 'permission_group_id' => 7]);
        Permission::create(['name' => 'Empleados Ver', 'action' => 'employees.show', 'permission_group_id' => 7]);
        Permission::create(['name' => 'Empleados Crear', 'action' => 'employees.create', 'permission_group_id' => 7]);
        Permission::create(['name' => 'Empleados Editar', 'action' => 'employees.edit', 'permission_group_id' => 7]);
        Permission::create(['name' => 'Empleados Eliminar', 'action' => 'employees.destroy', 'permission_group_id' => 7]);
        // Cotizaciones orders
        Permission::create(['name' => 'Cotizaciones Listar', 'action' => 'orders.index', 'permission_group_id' => 5]);
        Permission::create(['name' => 'Cotizaciones Ver', 'action' => 'orders.show', 'permission_group_id' => 5]);
        Permission::create(['name' => 'Cotizaciones Crear', 'action' => 'orders.create', 'permission_group_id' => 5]);
        Permission::create(['name' => 'Cotizaciones Editar', 'action' => 'orders.edit', 'permission_group_id' => 5]);
        Permission::create(['name' => 'Cotizaciones Eliminar', 'action' => 'orders.destroy', 'permission_group_id' => 5]);
        // Compras
        Permission::create(['name' => 'Compras Listar', 'action' => 'purchases.index', 'permission_group_id' => 4]);
        Permission::create(['name' => 'Compras Ver', 'action' => 'purchases.show', 'permission_group_id' => 4]);
        Permission::create(['name' => 'Compras Crear', 'action' => 'purchases.create', 'permission_group_id' => 4]);
        Permission::create(['name' => 'Compras Editar', 'action' => 'purchases.edit', 'permission_group_id' => 4]);
        Permission::create(['name' => 'Compras Eliminar', 'action' => 'purchases.destroy', 'permission_group_id' => 4]);
        */
    }
}