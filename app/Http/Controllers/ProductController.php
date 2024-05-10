<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public  $count = 0;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function aa(Request $abc)
    {
        $imagename = time() . '.' . $abc->image->extension();
        $abc->image->move(public_path('prod'), $imagename);
        $prod = new Product;
        $prod->name = $abc->prod;
        $prod->price = $abc->price;
        $prod->quantity = $abc->quantity;
        $prod->des = $abc->des;
        $prod->image = $imagename;
        $prod->save();
        return back()->withSuccess("prod created");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id)
    {
        $count = session()->get('count', 0);


        $product = Product::find($id);
        if ($product) {

            $productIds = session()->get('productIds', []);

            if (!in_array($product->id, $productIds)) {

                // Add the new product ID to the array
                $productIds[] = $product->id;
                // Store the updated array back into the session
                session()->put('productIds', $productIds);
                $count++;

                // Store the updated count back into the session
                session()->put('count', $count);
            }
        }



        // print_r($product);
        // return view('admin.check',compact('count'));

        // $prod = product::all();
        return back()->with('status', 'Your action was successful!');
    }
    public function displayProducts()
    {
        // Retrieve product IDs from the session
        $productIds = session()->get('productIds', []);

        // Fetch data from the database based on the product IDs
        $products = Product::whereIn('id', $productIds)->get();
        session()->put("quantity", 1);
        // Pass the fetched data to the Blade view for display
        return view('admin.showProduct', ['products' => $products]);
    }

    public function checkout()
    {
        $orders =  new Order();
        $userId =  Auth::user()->id;

        $productIds = session()->get('productIds', []);
        $products = Product::whereIn('id', $productIds)->get();

        foreach ($products as $product) {
            $orders->userid =  $userId;
            $orders->productid =  $product->id;
            $orders->totalprice =  session()->get("totalPrice");
            $orders->save();

            $quantityInCart = session()->get('quantity_' . $product->id, 1);

            $updatedQuantity = $product->quantity - $quantityInCart;
            echo $updatedQuantity;


            if ($updatedQuantity === 0) {
                $product->quantity = $updatedQuantity;
                $product->save();
                // $product->delete();
            } else {
                // Otherwise, update the database quantity
                $product->quantity = $updatedQuantity;
                $product->save();


            }
           
        }

        session()->forget('productIds');
        session()->forget('quantity');
        session()->forget('totalPrice');
        session()->forget('count');
        return  redirect('/show')->with('success', 'Your order has been placed!');
    }

    public function deleteFromSession($id)
    {
        session()->forget('quantity_' . $id);
        session()->forget('product_' . $id);
        session()->forget('totalPrice_' . $id);
        $count = session()->get('count', 0);
        if ($count > 0) {
            session()->put('count', $count - 1);
        }
    }
    /** 
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $abc)
    {
        $prod = product::all();
        return view('admin.show', compact('prod'));
    }
    public function stat($abc)
    {
        $prod = Product::find($abc);
        if ($prod) {
            if ($prod->status) {
                $prod->status = 0;
            } else {
                $prod->status = 1;
            }
            $prod->save();
        }
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {

        $product = Product::find($id);
        print_r($product);
        $product->delete();
        return back()->withSuccess('Product deleted!');
    }
}
