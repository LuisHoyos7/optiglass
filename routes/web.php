<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('dashboard');
})->middleware('auth');

//preventas
Route::get('afiliaciones/obtenerValorCuota', 'AfiliacionesControlador@obtenerValorCuota');
Route::post('afiliaciones/lote', 'AfiliacionesControlador@editarLote');
Route::resource('afiliaciones', 'AfiliacionesControlador')->only([
    'index', 'store', 'update'
]);

//Clientes afiliacion
//Route::get('clientesafiliacion/{id}', 'ClientesAfiliacionControlador@show');
Route::get('clientesafiliacion/telefono', 'ClientesAfiliacionControlador@findByPhonenumber');
Route::resource('clientesafiliacion', 'ClientesAfiliacionControlador')->only([
    'update', 'show'
]);

//Clientes
Route::post('clientes/guardar', 'ClientesControlador@registrar');
Route::post('clientes/consultar', 'ClientesControlador@consultar');
Route::get('clientes/consultarTodos', 'ClientesControlador@consultarTodos');
Route::get('clientes/consultarTelefonosDuplicados', 'ClientesControlador@consultarTelefonosDuplicados');

//Parametros de gastos
Route::get('parametros', 'ParametrosGastosControlador@index');
Route::post('parametros/guardar', 'ParametrosGastosControlador@guardar');
Route::post('parametros/editar', 'ParametrosGastosControlador@editar');
Route::get('parametros/consultar', 'ParametrosGastosControlador@consultar');

//Ganancias y gastos
Route::get('gastosganancias/configuracion', 'GastosGananciasControlador@consultarConfiguracion');
Route::resource('gastosganancias', 'GastosGananciasControlador')->only([
    'index', 'store', 'update'
]);

//Usuarios
Route::put('usuarios/{codigo}/clave', 'UsuariosControlador@cambiarClave');
Route::get('usuarios/filtro', 'UsuariosControlador@consultarUsuarios');
Route::get('usuarios/login', 'UsuariosControlador@consultarUsuarioLogin');
Route::resource('usuarios', 'UsuariosControlador')->only([
    'index', 'store', 'update'
]);

//Roles
Route::resource('roles', 'RolesControlador')->only([
    'index'
]);

//Brigadas
Route::get('brigadas/filtro', 'BrigadasControlador@consultarBrigadas');
Route::get('brigadas/afiliacion', 'BrigadasControlador@ConsultaBrigadasAfiliacion');
Route::get('brigadas/show/{id}', 'BrigadasControlador@show');
Route::resource('brigadas', 'BrigadasControlador')->only([
    'index', 'show', 'store', 'update'
]);

//Estado preventas
Route::resource('estados', 'EstadosControlador')->only([
    'index', 'store', 'update'
]);
Route::get('estados/activo', 'EstadosControlador@consultarEstadosActivo');

//subestado
Route::get('subestados/filtro', 'SubestadosControlador@consultarSubestados');
Route::resource('subestados', 'SubestadosControlador')->only([
    'index', 'store', 'update'
]);

//Revision afiliaciones
Route::get('revision', 'RevisionAfiliacionesControlador@index');

//cargar maletines
Route::resource('cargarmaletines', 'CargarMaletinControlador')->only([
    'index', 'store'
]);

//CallDealer
Route::post('callDealer/guardar', 'CallDealerControlador@guardar');
Route::get('callDealer/{id}/historial', 'CallDealerControlador@consultarHistorial');
Route::resource('callsdealer', 'CallDealerControlador')->only([
    'index', 'store'
]);

//Parametros ssistemas
Route::resource('parametossistema', 'ParametrosSistemaControlador')->only([
    'show'
]);

//Asistencias
Route::get('asistencias', 'AsistenciasControlador@index');
Route::post('asistencias/guardar', 'AsistenciasControlador@guardar');
Route::post('asistencias/validar', 'AsistenciasControlador@validarConsecutivo');
Route::get('asistencias/consultar', 'AsistenciasControlador@consultar');

//Lentes
Route::get('lentes/consultarLentes', 'TiposLentesControlador@consultarLentes');
Route::resource('lentes', 'TiposLentesControlador')->only([
    'index', 'store', 'update'
]);

//Ventas
Route::get('ventas', 'VentasControlador@index');
Route::get('ventas/consultarFormula', 'VentasControlador@consultarFormula');
Route::get('ventas/consultarAdicion', 'VentasControlador@consultarAdicion');
Route::get('ventas/consultarCliente', 'VentasControlador@consultarCliente');
Route::get('ventas/consultarVentas', 'VentasControlador@consultarVentas');
Route::post('ventas/guardar/{formula}', 'VentasControlador@guardar');
Route::post('ventas/imprimir', 'VentasControlador@imprimir');

//Entregas
Route::get('entregas', 'EntregasControlador@index');
Route::get('entregas/consultar', 'EntregasControlador@consultar');
Route::post('entregas/guardar', 'EntregasControlador@guardar');

//Errores
Route::get('errores', 'ErroresControlador@index');
Route::post('errores/guardar', 'ErroresControlador@guardar');
Route::post('errores/editar', 'ErroresControlador@editar');
Route::get('errores/consultar', 'ErroresControlador@consultar');
Route::get('errores/filtro', 'ErroresControlador@consultarErrores');

//Errores
Route::get('quejas', 'QuejasControlador@index');
Route::post('quejas/guardar', 'QuejasControlador@guardar');
Route::get('quejas/consultar', 'QuejasControlador@consultar');
Route::get('quejas/consultarErrores', 'QuejasControlador@consultarErrores');

//Liquidacion
Route::get('liquidacion', 'LiquidacionControlador@index');
Route::post('liquidacion/guardar', 'LiquidacionControlador@guardar');
Route::post('liquidacion/consultarErrores', 'LiquidacionControlador@consultarErrores');
Route::get('liquidacion/consultar', 'LiquidacionControlador@consultar');

//Reportes liquidacion
Route::get('reportesLiquidacion', 'ReportesLiquidacionControlador@index');
Route::get('reportesLiquidacion/consultar', 'ReportesLiquidacionControlador@consultar');
Route::post('reportesLiquidacion/resumen', 'ReportesLiquidacionControlador@calcularResumen');
Route::post('reportesLiquidacion/imprimir', 'ReportesLiquidacionControlador@imprimir');

//Consultar afiliaciones
Route::get('consultarAfiliaciones', function () {
    return view('consultarAfiliaciones');
});
Route::get('consultarAfiliaciones/imprimir/{afiliaciones}', 'ConsultarAfiliacionesControlador@imprimir');
Route::get('consultarAfiliaciones/consultar', 'ConsultarAfiliacionesControlador@consultar');

//Ubicacion
Route::get('ubicaciones/provincias', 'UbicacionControlador@consultarProvincias');
Route::get('ubicaciones/cantones', 'UbicacionControlador@consultarCantones');
Route::get('ubicaciones/parroquias', 'UbicacionControlador@consultarParroquias');

//Login
Route::get('login', 'LoginControlador@showLogin')->name('login'); // Mostrar login
Route::post('login', 'LoginControlador@login'); // Verificar datos
Route::get('logout', 'LoginControlador@logOut'); // Finalizar sesión

Route::get('/config-cache', function() {      $exitCode = Artisan::call('config:cache');      return '<h1>Clear Config cleared</h1>';  });


//liquidacion brigada 

Route::resource('liquidacionBrigada', 'LiquidacionBrigadaController');

/*\DB::listen(function ($sql) {
    var_dump($sql->sql);
});*/
