<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductContoller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ProductCollection(Product::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $request->validated();
        
        $request['slug'] = $this->createSlug($request['name']);
        $product = Product::create($request->all());
        return $product;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $term)
    {
        $product = Product::where('id', $term)->orWhere('slug',$term)->get();
        return new ProductResource( $product[0] );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::find($id);

        if( !$product ){
            return response()->json([
                'message' => 'No se encontro el producto'
            ], 404);
        };

        $request['slug'] = $this->createSlug($request['name']);

        $product->update( $request->all() );
        return response()->json([
            'message' => 'Producto actualizado'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);

        if( !$product ){
            return response()->json([
                'message' => 'No se encontro la categoria'
            ], 404);
        };

        $product->delete();
        return response()->json([
            'message' => 'Producto eliminado'
        ], 200);
    }

    
    function createSlug($text)
    {
        $text = strtolower($text); 
        $text = preg_replace('/[^a-z0-9]+/','_',$text);
        $text = trim($text, '_');
        $text = preg_replace('/_+/','_',$text);

        return $text;   
    }
}
