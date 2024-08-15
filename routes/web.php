<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\PriceController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\PreviewController;
use App\Http\Controllers\ConfirmController;
use App\Http\Controllers\SMSController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth','admin'])->prefix('admin-panel/dashboard')->name('admin.')->group(function () {
    
    Route::get('/' , [ProductController::class  , 'dashboard'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::resource('products.prices', PriceController::class);
    Route::resource('orders', OrderController::class)->only(['index', 'show']);
});

Auth::routes();

// Route::post('export', [HomeController::class, 'pdfsave']);
// Route::get('/export/form' , [HomeController::class  , 'form']);
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login/'); 
})->name('logout');

 Route::get('/form' , [HomeController::class  , 'form']);
 Route::post('/request-preview', [PreviewController::class, 'requestPreview']);

 Route::post('/export', [ConfirmController::class, 'confirmDetails']);