<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Session;

class CartController extends Controller
{
    //constructor 
    //called automatically when an object of the class is created
    public function __construct()
    {
        $this->middleware(function ($request, $next){
            // If the session ID and/or IP address are not already set in the session
            if (!$request->session()->has('session_id')) {
                //generates a unique session ID
                $session_id = uniqid();
                Session::put('session_id', $session_id);
            }
    
            if (!$request->session()->has('ip_address')) {
                // retrieves the IP address from the request
                $ip_address = $request->ip();
                Session::put('ip_address', $ip_address);
            }
            return $next($request);
        });
    }

    public function index()
    {
        $cartItems = Cart::where('session_id', session()->getId())->get();
        return view('cart.index', compact('cartItems'));
    }

    public function update(Request $request, $id)
    {
        $item = Cart::find($id);

        if (!$item) {
            return redirect()->route('cart.index')->with('error', 'Item not found in cart.');
        }
    
        $quantity = (int) $request->input('quantity');
        if ($quantity > $item->item->quantity) {
            return redirect()->route('cart.index')->with('error', 'Quantity exceeds available stock for this item.');
        }
        $item->quantity = $quantity;
        $item->save();
    
        return redirect()->route('cart.index')->with('success', 'Cart updated successfully.');
    }

    public function remove(Request $request, $id)
    {
        $cartItem = Cart::find($id);
    
        if (!$cartItem) {
            abort(404);
        }
    
        $cartItem->delete();
    
        return redirect()->route('cart.index')->with('success', 'Item has been removed from your cart.');
    }
}
