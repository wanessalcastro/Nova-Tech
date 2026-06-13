<?php
// Comentario Nova Tech: Arquivo app/Http/Controllers/CartController.php. Origem: Camada de controllers. Conteudo: Recebe requisicoes, consulta models e retorna views ou redirecionamentos da funcionalidade.

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with('product')
                        ->where('user_id', Auth::id())
                        ->get();

        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request, int $id)
    {
        $cart = Cart::where('user_id', Auth::id())
                    ->where('product_id', $id)
                    ->first();

        if ($cart) {
            $cart->increment('quantity');
        } else {
            Cart::create([
                'user_id'    => Auth::id(),
                'product_id' => $id,
                'quantity'   => 1,
            ]);
        }

        return back()->with('success', 'Produto adicionado ao carrinho!');
    }

    public function remove(int $id)
    {
        Cart::where('user_id', Auth::id())
            ->where('product_id', $id)
            ->delete();

        return back()->with('success', 'Produto removido do carrinho!');
    }

    public function clear()
    {
        Cart::where('user_id', Auth::id())->delete();

        return back()->with('success', 'Carrinho limpo com sucesso!');
    }

    // Compra direta: limpa o carrinho, adiciona só esse produto e vai para o checkout
    public function buyNow(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity  = $request->input('quantity', 1);

        Cart::where('user_id', Auth::id())->delete();

        Cart::create([
            'user_id'    => Auth::id(),
            'product_id' => $productId,
            'quantity'   => $quantity,
        ]);

        return redirect()->route('checkout.index');
    }

    // Redireciona para o fluxo de checkout
    public function checkout()
    {
        $cartItems = Cart::with('product')
                        ->where('user_id', Auth::id())
                        ->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Seu carrinho está vazio!');
        }

        return redirect()->route('checkout.index');
    }

    public function update(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        Cart::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->update([
                'quantity' => $request->quantity,
            ]);

        return back()->with('success', 'Quantidade atualizada.');
    }
}
