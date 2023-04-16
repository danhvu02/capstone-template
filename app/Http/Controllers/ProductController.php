<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Item;
use App\Models\Cart;
use Image;
use Storage;
use Session;

class ProductController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($category_id = null) // defines a default value null for category_id 
    {
        $categories = Category::all()->sortBy('name');
    
        $query = Item::query();
    
        //if a category ID is passed,
        if ($category_id) {
            //filter the items by the selected category
            $query->where('category_id', $category_id);
        }

        //dd($category_id);
        //retrieve the items from the database based on the query
        $items = $query->orderBy('title')->get();
    
        //return view('products.index', compact('categories', 'items', 'category_id'));
        return view('products.index')->with('categories', $categories)->with('items', $items)->with('category_id', $category_id);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Item::find($id);
        return view('products.show')->with('item',$item);
    }


    public function addToCart(Request $request, $id)
    {
        $item = Item::find($id);

        //if the item doesn't exist, return a 404 error.
        if(!$item) {
            abort(404);
        }

        $cart = new Cart();
        $cart->item_id = $item->id;
        $cart->session_id = session()->getId();
        $cart->ip_address = $request->ip();
        $cart->quantity = 1;
        $cart->save();

        return redirect()->route('cart');
    }   

}
