<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CheckoutController;

use App\Http\Controllers\Admin\OrderAdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CustomerAdminController;
use App\Http\Controllers\Admin\CategoryAdminController;
use App\Http\Controllers\Customer\CustomerDashboardController;
use App\Http\Controllers\Admin\PostAdminController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\Admin\NewsletterAdminController;
use App\Http\Controllers\NewsletterSendController;
use App\Http\Controllers\Admin\DollarValueController;
use App\Http\Controllers\Admin\SettingController;

use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/etiqueta/{slug}', [BlogController::class, 'tag'])->name('blog.tag');

Route::post('/newsletter', [NewsletterController::class, 'store'])->name('newsletter.store');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/success/{orderId}', [CheckoutController::class, 'success'])->name('checkout.success');

Route::post('/products/{product}/inline-update', [ProductController::class, 'inlineUpdate'])
    ->name('products.inline-update');

Route::get('/marca/{slug}', [ProductController::class, 'byBrand'])->name('shop.byBrand');
Route::get('/category/{slug}', [ProductController::class, 'byCategory'])->name('shop.byCategory');

Route::get('/producto/{slug}', [ProductController::class, 'detail'])->name('product.detail');

Route::post('/cart/ajax-add/{id}', [CartController::class, 'ajaxAdd'])->name('cart.ajax-add');

Route::get('/shop', [ProductController::class, 'shop'])->name('shop.index');

//area clienets 


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/mi-area', [CustomerDashboardController::class, 'index'])
        ->name('customer.dashboard');
});


//area admin


Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    Route::get('/admin/newsletter/send', [NewsletterSendController::class, 'form'])
        ->name('admin.newsletter.form');

    Route::post('/admin/newsletter/send', [NewsletterSendController::class, 'send'])
        ->name('admin.newsletter.send');

    // Admin
    Route::resource('posts', PostAdminController::class)->names('admin.posts');

    Route::get('/admin/newsletters', [NewsletterAdminController::class, 'index'])
        ->name('admin.newsletters.index');

    Route::get('/customers', [CustomerAdminController::class, 'index'])->name('admin.customers.index');
    Route::get('/customers/{user}', [CustomerAdminController::class, 'show'])->name('admin.customers.show');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::resource('products', ProductController::class);

    Route::resource('categories', CategoryAdminController::class)->names('admin.categories');

    Route::resource('sliders', SliderController::class);

    // Ruta adicional para reordenar sliders (opcional - para futuro)
    Route::post('sliders/reorder', [SliderController::class, 'reorder'])->name('sliders.reorder');

    Route::resource('brands', BrandController::class);

    Route::get('/orders', [OrderAdminController::class, 'index'])->name('admin.orders.index');
    Route::get('/orders/{order}', [OrderAdminController::class, 'show'])->name('admin.orders.show');
    Route::post('/orders/{order}/status', [OrderAdminController::class, 'updateStatus'])->name('admin.orders.status');

    Route::resource('dollar-values', DollarValueController::class)->names('admin.dollar-values');

    // Configuración
    Route::get('/settings', [SettingController::class, 'edit'])->name('admin.settings.edit');
    Route::put('/settings', [SettingController::class, 'update'])->name('admin.settings.update');
});



require __DIR__ . '/auth.php';
