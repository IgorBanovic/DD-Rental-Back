<?php

namespace App\Http\Requests\Car;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCarRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => 'required|in:coupe,limousine,SUV',
            'brand' => 'required|in:Volkswagen,Skoda',
            'year' => 'required|numeric|min:2000|max:' . date('Y'),
            'price' => 'required|numeric',
            'status' => 'required|in:returned,in use,reserved',
            'description' => 'required|string|min:50|max:250',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }
}
