<?php

use App\Http\Controllers\IndexController;
use App\Http\Middleware\EnsureUserIsAdmin;
use App\Jobs\ParseOrder;
use App\Services\GoogleService;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TelegramBotController;

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
//    $gog = new GoogleService();
//    $data_full =  $gog->readGoogleSheet();
//    foreach ($data_full as $data) {
//        if ($data === $data_full[0]) {
//            continue;
//        } elseif ($data[2] == '') {
//            continue;
//        }
//        $orderr = new ParseOrder($data);
//        $orderr->handle();
//
//
//    }
    return view('index.index');
})->name('index');
Route::get('/about', [IndexController::class, 'about'])->name('about');
Route::get('/prices', [IndexController::class, 'prices'])->name('prices');
Route::get('/docs', [IndexController::class, 'docs'])->name('docs');
Route::get('/order', [IndexController::class, 'order'])->name('order');
Route::post('/order', [IndexController::class, 'order_post'])->name('order');
//Route::get('/order', [IndexController::class, 'index_order'])->name('index_order');
Route::post('/route_save', [IndexController::class, 'save_routes'])->name('save_routes');
Route::post('/save_cities', [IndexController::class, 'save_cities'])->name('save_cities');
Route::get('/email', [\App\Http\Controllers\Admin\EmailController::class, 'test'])->name('email');
Route::get('/status', [IndexController::class, 'status'])->name('status');
Route::get('/success/{order_id}', [IndexController::class, 'success'])->name('success');
Route::get('/files/{order_id}/{file}', [\App\Http\Controllers\FilesController::class, 'show'])->name('files');

Route::get('/order/{id}/repeat', [App\Http\Controllers\IndexController::class, 'order_repeat'])->name('order.repeat');
Route::post('/order/repeat', [App\Http\Controllers\IndexController::class, 'order_repeat_save'])->name('order.repeat_save');

Route::get('/excel/orders', [IndexController::class, 'excel_orders']);

Route::get('/contacts', [IndexController::class, 'contacts'])->name('contacts');
Route::get('/account', [\App\Http\Controllers\AccountController::class, 'account'])->middleware(['auth'])->name('account');

Route::prefix('admin')->name('admin.')->middleware(['auth', EnsureUserIsAdmin::class])->group(function ()  {
    Route::resource('/application', App\Http\Controllers\Admin\ApplicationController::class)->names('application');
    Route::get('/orders', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/reports', [App\Http\Controllers\Admin\ReportsController::class, 'index'])->name('reports.index');
    Route::get('/take', [App\Http\Controllers\Admin\TakeController::class, 'index'])->name('take.index');
    Route::get('/debt', [App\Http\Controllers\Admin\DebtController::class, 'index'])->name('debt.index');
    Route::get('/give', [App\Http\Controllers\Admin\GiveController::class, 'index'])->name('give.index');
    Route::get('/print', [App\Http\Controllers\Admin\PrintController::class, 'index'])->name('print.index');
    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('user.index');
    Route::get('/savegoogle', [\App\Http\Controllers\GoogleController::class, 'index']);
    Route::get('/files/reload/{id}', [\App\Http\Controllers\Admin\PrintController::class, 'reload'])->name('files.reload');
    Route::get('/files/{order_id}/{file}', [\App\Http\Controllers\Admin\PrintController::class, 'show'])->name('files');
    Route::get('/manager_account', [\App\Http\Controllers\Admin\ManagerAccountController::class, 'index'])->name('manager_account');
    Route::get('/orders/{id}/repeat', [App\Http\Controllers\Admin\OrderController::class, 'repeat'])->name('orders.repeat');
    Route::post('/orders/repeat', [App\Http\Controllers\Admin\OrderController::class, 'repeat_save'])->name('orders.repeat_save');


});


