<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'stock' => $this->stock,
            'slug' => $this->slug,
            'price' => $this->price,
            'image' => $this->image,
            'category' => Category::where('id', $this->category_id)->get()[0],

            'createdAt' => $this->created_at,
        ];
    }
}
