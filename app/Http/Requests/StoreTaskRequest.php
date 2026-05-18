<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'title'    => ['required', 'string', 'min:2', 'max:120'],
            'priority' => ['sometimes', 'required', 'string', 'in:low,medium,high'],
        ];
    }

     protected function prepareForValidation(): void
    {
        $this->merge([
            'title' => strip_tags($this->title),
        ]);
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Task title is required.',
            'title.min'      => 'Task title must be at least 2 characters.',
            'title.max'      => 'Task title cannot exceed 120 characters.',
            'priority.in'    => 'Priority must be low, medium, or high.',
        ];
    }
}
