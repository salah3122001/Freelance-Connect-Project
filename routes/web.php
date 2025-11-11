<?php


use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ServiceController;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $services = Service::with('freelancer')->where('status', 'approved')->get();
    return view('services.index', compact('services'));
});

Route::post('/search', [ServiceController::class, 'search'])->name('search');

Auth::routes(['verify' => true]);


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'isAdmin'])->prefix('admin')->group(function () {

    Route::get('/adminsearch', [DashboardController::class, 'adminsearch'])->name('adminsearch');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/charts', [DashboardController::class, 'charts'])->name('admin.charts');
    Route::get('services/lastservices', [DashboardController::class, 'lastservices'])->name('admin.pendingservices');
    Route::get('/services/approve/{id}', [DashboardController::class, 'approve'])->name('admin.service.approve');
    Route::delete('/services/reject/{id}', [DashboardController::class, 'reject'])->name('admin.service.reject');
    Route::get('/allservices', [DashboardController::class, 'allservices'])->name('admin.allservices');
    Route::get('/approvedservices', [DashboardController::class, 'approvedservices'])->name('admin.approvedservices');
    Route::get('/rejectedservices', [DashboardController::class, 'rejectedservices'])->name('admin.rejectedservices');
    Route::get('/clients', [UserController::class, 'clients'])->name('admin.clients');
    Route::get('/freelancers', [UserController::class, 'freelancers'])->name('admin.freelancers');
    Route::get('users/{id}', [UserController::class, 'show'])->name('admin.user.show');
    Route::get('user/ban/{id}', [UserController::class, 'ban'])->name('admin.user.ban');
    Route::get('user/unban/{id}', [UserController::class, 'unban'])->name('admin.user.unban');
    Route::delete('user/delete/{id}', [UserController::class, 'deleteUser'])->name('admin.user.delete');
});


Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('services', ServiceController::class);

    Route::get('/getservices', [OrderController::class, 'get'])->name('services.get');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/freelancerStatistics', [OrderController::class, 'freelancerStatistics'])->name('orders.freelancerStatistics');
    Route::post('/orders/store/{service}', [OrderController::class, 'store'])->name('orders.store');
    Route::post('/orders/destroy/{service}', [OrderController::class, 'destroy'])->name('orders.destroy');

    Route::get('orders/{order}/chat', [ChatController::class, 'show'])->name('orders.chat');
    Route::post('chat/{chat}/send', [ChatController::class, 'sendMessage'])->name('chat.send');

    Route::get('/orders/{order}/payment', [PaymentController::class, 'create'])->name('payment.create');
    Route::post('/orders/{order}/payment', [PaymentController::class, 'store'])->name('payment.store');

    Route::get('/orders/{order}/paymob/pay', [PaymentController::class, 'pay'])->name('payment.pay');
    Route::get('/payment/processing', [PaymentController::class, 'processing'])->name('payment.processing');
    Route::post('/payment/paymob/callback', [PaymentController::class, 'callback'])->name('payment.callback');

    Route::get('/payment/paymob/callback', [PaymentController::class, 'callback'])->name('payment.redirect');
});
