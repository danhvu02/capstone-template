<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Item;
use Image;
use Storage;
use Session;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Move the image to the images directory
        $filename = $request->file('picture')->getClientOriginalName();
        $request->file('picture')->move(public_path('images/items/'), $filename);

        // Resize the thumbnail
        $thumbnail = Image::make(public_path('images/items/' . $filename));
        $thumbnail->resize(100, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $thumbnail->save(public_path('images/items/tn_' . $filename));

        // Resize the large image
        $largeImage = Image::make(public_path('images/items/' . $filename));
        $largeImage->resize(600, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $largeImage->save(public_path('images/items/lrg_' . $filename));

        // Save the new item to the database
        $item = new Item();
        $item->title = $request->input('title');
        $item->description = $request->input('description');
        $item->category_id = $request->input('category_id');
        $item->price = $request->input('price');
        $item->quantity = $request->input('quantity');
        $item->sku = $request->input('sku');
        $item->image = $filename;
        $item->save();
    }
}
