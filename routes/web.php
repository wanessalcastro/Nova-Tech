<?php
// Comentario Nova Tech: Arquivo routes/web.php. Origem: Camada de rotas Laravel. Conteudo: Define as rotas principais do site, loja, carrinho, checkout, perfil e area admin.

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // Importado para garantir o funcionamento de Auth::check()
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Models\Product;

Route::get('/produto/{id}', [App\Http\Controllers\ProductController::class, 'show'])->name('product.show');

/*
|--------------------------------------------------------------------------
| ROTAS PÚBLICAS
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (Auth::check() && ! request()->boolean('site')) {
        return redirect()->route('dashboard');
    }
    return view('welcome', [
        'products' => Product::query()->latest()->take(4)->get()
    ]);
})->name('home');

Route::get('/loja', function () {
    $selectedBrand = request('brand');
    $selectedPriceRange = request('price_range');

    $brands = collect(['Apple', 'Samsung', 'Xiaomi'])
        ->merge(Product::query()
        ->whereNotNull('category')
        ->select('category')
        ->distinct()
        ->orderBy('category')
        ->pluck('category')
        ->filter())
        ->unique()
        ->sort()
        ->values();

    $productsQuery = Product::query();

    if ($selectedBrand) {
        $productsQuery->where('category', $selectedBrand);
    }

    match ($selectedPriceRange) {
        '0-1500' => $productsQuery->whereBetween('price', [0, 1500]),
        '1500-3000' => $productsQuery->whereBetween('price', [1500, 3000]),
        '3000-5000' => $productsQuery->whereBetween('price', [3000, 5000]),
        '5000-plus' => $productsQuery->where('price', '>=', 5000),
        default => null,
    };

    $products = $productsQuery
        ->orderBy('category')
        ->orderBy('name')
        ->get();

    $productsByBrand = $products->groupBy('category');

    return view('loja', compact(
        'productsByBrand',
        'brands',
        'selectedBrand',
        'selectedPriceRange'
    ));
})->name('loja');

Route::view('/suporte', 'support')->name('support');


/*
|--------------------------------------------------------------------------
| CLIENTE (AUTENTICADO)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Perfil
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    // Carrinho
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add/{id}', [CartController::class, 'add'])->name('add');
        Route::patch('/{product}', [CartController::class, 'update'])->name('update');
        Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('remove');
        Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
        Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
        Route::post('/buy-now', [CartController::class, 'buyNow'])->name('checkout.direct');
    });

    // Checkout do Cliente
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout.index');
    Route::get('/checkout/entrega', [OrderController::class, 'delivery'])->name('checkout.delivery');
    Route::post('/checkout/pagamento', [OrderController::class, 'payment'])->name('checkout.payment');
    Route::post('/checkout/confirmar', [OrderController::class, 'confirm'])->name('checkout.confirm');
    Route::post('/checkout/finalizar', [OrderController::class, 'store'])->name('checkout.store');

    // Pedidos
    Route::get('/pedidos/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/meus-pedidos', [OrderController::class, 'index'])
    ->name('orders.index');
});


/*
|--------------------------------------------------------------------------
| PAINEL ADMINISTRATIVO (ADMIN)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () { // Fechamento e abertura corretos da Função Anônima

        // Dashboard Admin
        Route::get('/dashboard', [AdminController::class, 'admin'])->name('dashboard');
        Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
        Route::get('/sales', [AdminController::class, 'sales'])->name('sales');



        // CRUD Completo de Produtos
        Route::prefix('produtos')->name('products.')->group(function () {
            Route::get('/', [AdminProductController::class, 'index'])->name('index');
            Route::get('/create', [AdminProductController::class, 'create'])->name('create');
            Route::post('/salvar', [AdminProductController::class, 'store'])->name('store');
            Route::get('/editar/{id}', [AdminProductController::class, 'edit'])->name('edit');
            Route::put('/atualizar/{id}', [AdminProductController::class, 'update'])->name('update');
            Route::delete('/deletar/{id}', [AdminProductController::class, 'destroy'])->name('destroy');
        });
    });

require __DIR__.'/auth.php';
