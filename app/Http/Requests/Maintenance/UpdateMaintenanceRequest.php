<?php

namespace App\Http\Requests\Maintenance;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMaintenanceRequest extends FormRequest
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
            'appointment' => 'required|date|after:today',
            'description' => 'required|string|min:50|max:250',
            'car_id' => 'required|exists:cars,id',
        ];
    }
}
