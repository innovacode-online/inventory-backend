<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductContoller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Product::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validated();
        $request['slug'] = $this->createSlug($request['name']);
        Product::created($request->all());

        return response([
            'message' => 'Se creo el producto'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
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
