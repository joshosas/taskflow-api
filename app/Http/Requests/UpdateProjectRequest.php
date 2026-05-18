<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
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
            'name'        => ['sometimes', 'required', 'string', 'min:2', 'max:80'],
            'description' => ['sometimes', 'nullable', 'string', 'max:500'],
            'color'       => ['sometimes', 'required', 'string', 'in:slate,red,orange,amber,green,teal,blue,violet,pink'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('name')) {
            $this->merge(['name' => strip_tags($this->name)]);
        }

        if ($this->has('description')) {
            $this->merge([
                'description' => $this->description ? strip_tags($this->description) : null,
            ]);
        }
    }

    public function messages(): array
    {
        return [
            'name.min'  => 'Project name must be at least 2 characters.',
            'name.max'  => 'Project name cannot exceed 80 characters.',
            'color.in'  => 'Please select a valid color.',
        ];
    }
}
