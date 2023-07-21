<?php

namespace App\Http\Controllers;

use App\Http\Resources\SaleCollection;
use App\Http\Resources\SaleResource;
use App\Models\Product;
use App\Models\ProductSale;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new SaleCollection(Sale::with('products')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // GUARDAR VENTA
        $sale = new Sale;
        
        $sale->client = $request->client; 
        $sale->total = $request->total; 
        $sale->save();

        $sale_id = $sale['id'];


        // OBTENER EL ARREGLO DE PRODUCTOS
        $products = $request->products;
        $product_sale = [];

        // ITERAR EN EL ARREGLO PARA INSERTAR ID DE VENTA
        foreach ($products as $product) {
            $product_sale[] = [
                'sale_id' => $sale_id,
                'product_id' => $product['id'],
                'amount' => $product['amount'],
                'created_At' => Carbon::now(),
                'updated_At' => Carbon::now(),
            ];

            // ACTUALIZAR STOCK
            $product_updated = Product::find($product['id']);
            if( $product['amount'] > $product_updated['stock'] )
            {
                return response([ 'message' => 'No hay suficiente stock' ], 400);
            }

            $product_updated['stock'] = $product_updated['stock'] -  $product['amount'];
            $product_updated->update();
        }

        ProductSale::insert($product_sale);

        return response([ 'message' => 'Venta realizada con exito' ], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new SaleResource( Sale::where('id', $id)->with('products')->get()[0] );
    }
}
