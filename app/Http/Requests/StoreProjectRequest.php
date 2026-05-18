<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
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
            'name'        => ['required', 'string', 'min:2', 'max:80'],
            'description' => ['nullable', 'string', 'max:500'],
            'color'       => ['required', 'string', 'in:slate,red,orange,amber,green,teal,blue,violet,pink'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => strip_tags($this->name),
            'description' => $this->description ? strip_tags($this->description) : null,
        ]);
    }

     // Custom messages replace Laravel's default ones.
    public function messages(): array
    {
        return [
            'name.required' => 'Project name is required.',
            'name.min'      => 'Project name must be at least 2 characters.',
            'name.max'      => 'Project name cannot exceed 80 characters.',
            'color.in'      => 'Please select a valid color.',
        ];
    }
}
