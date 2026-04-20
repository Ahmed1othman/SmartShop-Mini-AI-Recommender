<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Smpita\TypeAs\TypeAs;

class CartController extends Controller
{
    /**
     * Display the cart contents.
     */
    public function index(): View
    {
        $cart = TypeAs::array(session()->get('cart', []));

        $products = Product::whereIn('id', array_keys($cart))->get();

        $total = $products->sum(fn (Product $product) => $product->price * TypeAs::int($cart[$product->id] ?? 0));

        return view('cart.index', compact('products', 'cart', 'total'));
    }

    /**
     * Add a product to the cart.
     */
    public function add(Request $request, Product $product): RedirectResponse
    {
        $cart = TypeAs::array(session()->get('cart', []));
        $quantity = TypeAs::int($request->input('quantity', 1));

        if (isset($cart[$product->id])) {
            $cart[$product->id] = TypeAs::int($cart[$product->id]) + $quantity;
        } else {
            $cart[$product->id] = $quantity;
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    /**
     * Update product quantity in the cart.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:99',
        ]);

        $cart = TypeAs::array(session()->get('cart', []));

        if (isset($cart[$product->id])) {
            $cart[$product->id] = TypeAs::int($request->input('quantity'));
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Cart updated!');
    }

    /**
     * Remove a product from the cart.
     */
    public function remove(Product $product): RedirectResponse
    {
        $cart = TypeAs::array(session()->get('cart', []));

        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Product removed from cart!');
    }

    /**
     * Complete the checkout process.
     */
    public function checkout(): RedirectResponse
    {
        session()->forget('cart');

        return redirect()->route('home')->with('success', 'Order confirmed! Thank you for your purchase.');
    }
}
