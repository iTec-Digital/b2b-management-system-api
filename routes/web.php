<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RecoverPasswordController;

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
    return view('welcome');
});

Route::get('/graphiql', function () {
    return view('GraphiQL.GraphiQL');
});

Route::get('/Test', [\App\Http\Controllers\TestController::class, 'index']);

Route::get('/test', function () {

    $UAP = new \App\Core\Features\UAP\UAP();
    //return $UAP->SetModuleActionAccessPermission(1, 'USERS', 'VIEW', false);
    return $UAP->FetchModulePermissions(1, 'USERS')['MODULE_ACCESS'];

    return $UAP->FetchModulePermissions(1, 'USERS');
    return $UAP->FetchModuleActionAccessPermission(1, 'USERS', 'ADD');
});

Route::get('/recover/password/new/{token__}', [RecoverPasswordController::class, 'NewPasswordPage']);
Route::post('/recover/password/new/{token__}', [RecoverPasswordController::class, 'UpdateUserPassword']);
