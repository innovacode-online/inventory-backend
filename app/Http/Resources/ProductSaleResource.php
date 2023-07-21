<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductSaleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            // 'product' => $this->product_id,
            'amount' => $this->amount,
            'product' => new ProductResource( Product::where('id', $this->product_id)->get()[0] ),
        ];
    }
}
