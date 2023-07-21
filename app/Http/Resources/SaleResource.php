<?php

namespace App\Http\Resources;

use App\Models\ProductSale;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'client' => $this->client,
            'total' =>  $this->total,
            // 'products' => $this->products,
            'details' => new ProductSaleCollection( ProductSale::where('sale_id', $this->id)->get() ),
        ];
    }
}
