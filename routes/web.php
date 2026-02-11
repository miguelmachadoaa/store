<?php

use App\Http\Controllers\Admin\CategoryAdminController;
use App\Http\Controllers\Admin\CustomerAdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DollarValueController;
use App\Http\Controllers\Admin\NewsletterAdminController;
use App\Http\Controllers\Admin\OrderAdminController;
use App\Http\Controllers\Admin\PostAdminController;
use App\Http\Controllers\Admin\ReviewAdminController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Customer\CustomerDashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\NewsletterSendController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/sitemap.xml', [SitemapController::class, 'index']);
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/etiqueta/{slug}', [BlogController::class, 'tag'])->name('blog.tag');

Route::post('/newsletter', [NewsletterController::class, 'store'])->name('newsletter.store');

Route::get('/dashboard', function () {
    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('customer.dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/coupon', [CartController::class, 'applyCoupon'])->name('cart.coupon.apply');
Route::post('/cart/coupon/remove', [CartController::class, 'removeCoupon'])->name('cart.coupon.remove');

Route::get('/marca/{slug}', [ProductController::class, 'byBrand'])->name('shop.byBrand');
Route::get('/category/{slug}', [ProductController::class, 'byCategory'])->name('shop.byCategory');

Route::get('/producto/{slug}', [ProductController::class, 'detail'])->name('product.detail');

Route::post('/cart/ajax-add/{id}', [CartController::class, 'ajaxAdd'])->name('cart.ajax-add');

Route::get('/shop', [ProductController::class, 'shop'])->name('shop.index');

// area clienets

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Área de Cliente
    Route::get('/mi-area', [CustomerDashboardController::class, 'index'])->name('customer.dashboard');
    Route::get('/mi-area/ordenes', [CustomerDashboardController::class, 'orders'])->name('customer.orders');
    Route::get('/mi-area/pagos', [CustomerDashboardController::class, 'payments'])->name('customer.payments');
    Route::get('/mi-area/reportar-pago', [CustomerDashboardController::class, 'reportPaymentForm'])->name('customer.payments.report');
    Route::post('/mi-area/reportar-pago', [CustomerDashboardController::class, 'storePaymentReport'])->name('customer.payments.store');
    Route::get('/mi-area/perfil', [CustomerDashboardController::class, 'profile'])->name('customer.profile');
    Route::patch('/mi-area/perfil', [CustomerDashboardController::class, 'updateProfile'])->name('customer.profile.update');
    Route::get('/mi-area/favoritos', [CustomerDashboardController::class, 'favorites'])->name('customer.favorites');

    Route::post('/wishlist/toggle/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success/{orderId}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/orders/{orderId}/invoice', [CheckoutController::class, 'downloadInvoice'])->name('orders.invoice');
});

// area admin

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
    Route::delete('/products/images/{image}', [ProductController::class, 'deleteImage'])
        ->name('products.images.destroy');
    Route::post('/products/{product}/inline-update', [ProductController::class, 'inlineUpdate'])
        ->name('products.inline-update');

    // Rutas de Reseñas (Admin)
    Route::get('/reviews', [ReviewAdminController::class, 'index'])->name('admin.reviews.index');
    Route::get('/reviews/{review}', [ReviewAdminController::class, 'show'])->name('admin.reviews.show');
    Route::put('/reviews/{review}/approve', [ReviewAdminController::class, 'approve'])->name('admin.reviews.approve');
    Route::delete('/reviews/{review}', [ReviewAdminController::class, 'destroy'])->name('admin.reviews.destroy');

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

    Route::resource('taxes', \App\Http\Controllers\Admin\TaxController::class)->names('admin.taxes');

    Route::resource('coupons', \App\Http\Controllers\Admin\CouponController::class)->names('admin.coupons');

    // POS Routes
    Route::prefix('pos')->name('admin.pos.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\PosController::class, 'index'])->name('index');
        Route::post('/customers/search', [\App\Http\Controllers\Admin\PosController::class, 'searchCustomers'])->name('customers.search');
        Route::post('/customers/store', [\App\Http\Controllers\Admin\PosController::class, 'storeCustomer'])->name('customers.store');
        Route::post('/products/search', [\App\Http\Controllers\Admin\PosController::class, 'searchProducts'])->name('products.search');
        Route::post('/orders/create', [\App\Http\Controllers\Admin\PosController::class, 'createOrder'])->name('orders.create');
    });
});

// Rutas de Reseñas (Públicas)
Route::post('/productos/{product}/reviews', [ReviewController::class, 'store'])
    ->middleware(['auth'])
    ->name('products.reviews.store');

require __DIR__.'/auth.php';
