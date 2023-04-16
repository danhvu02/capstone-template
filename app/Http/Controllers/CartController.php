<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Session;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Item;

use App\Models\ItemsSold;

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

    public function remove($id)
    {
        $cartItem = Cart::find($id);
    
        if (!$cartItem) {
            abort(404);
        }
    
        $cartItem->delete();
    
        return redirect()->route('cart.index')->with('success', 'Item has been removed from your cart.');
    }

    public function checkOrder(Request $request)
    {
        // validate form fields
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // fields are valid, insert order info
        $order = new Order;
        $order->session_id = $request->session()->getId();
        $order->ip_address = $request->ip();
        $order->first_name = $request->input('first_name');
        $order->last_name = $request->input('last_name');
        $order->phone = $request->input('phone');
        $order->email = $request->input('email');
        $order->save();
        $orderId = $order->id;

        $session_id = $request->session()->getId();
        $itemsInCarts = Cart::where('session_id', $session_id)->get(['item_id', 'quantity']);

        $itemsSold = [];
        $total = 0;
        foreach ($itemsInCarts as $cartItem) {
            $itemModel = Item::find($cartItem->item_id);
            $subtotal = $cartItem->quantity * $itemModel->price;
            $total += $subtotal;

            $itemsSold[] = [
                'item' => $itemModel,
                'quantity' => $cartItem->quantity,
                'subtotal' => $subtotal,
            ];

            $itemsSoldDB = new ItemsSold;
            $itemsSoldDB->order_id = $orderId;
            $itemsSoldDB->item_id = $cartItem->item_id;
            $itemsSoldDB->item_price = $itemModel->price;
            $itemsSoldDB->quantity = $cartItem->quantity;
            $itemsSoldDB->save();
        }

        // unset session_id
        $request->session()->forget('session_id');
        $request->session()->regenerate();

        // redirect to thank you page with order info
        return view('cart.thankyou')->with([
            'orderId' => $orderId,
            'firstName' => $order->first_name,
            'lastName' => $order->last_name,
            'phone' => $order->phone,
            'email' => $order->email,
            'itemsSold' => $itemsSold,
            'total' => $total,
        ]);


    }
}
