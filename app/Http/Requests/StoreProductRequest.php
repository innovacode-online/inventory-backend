<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'          => 'required|unique:products,name',
            'description'   => 'required',
            'stock'         => 'required',
            'price'         => 'required',
            'category_id'   => 'required',
            'image'         => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required'         =>  'Se requiere el nombre',
            'name.unique'           =>  'Ya existe un producto con este nombre',
            'description.required'  =>  'Debe agregar una descripcion',
            'category_id.required'  =>  'Debe asignar una categoria',
            'stock.required'        =>  'Debe agregar una cantidad de stock',
            'price.required'        =>  'Debe añadir un precio',
            'image.required'        =>  'Se requiere una imagen',
        ];
    }
}
