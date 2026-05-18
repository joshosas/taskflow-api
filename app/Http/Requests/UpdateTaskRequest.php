<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
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
        // This request covers two scenarios Vue will send:
        // 1. Toggling completion:  { "completed": true }
        // 2. Editing a task:       { "title": "...", "priority": "high" }
        // 'sometimes' handles both — only the fields sent get validated.
        return [
            'title'     => ['sometimes', 'required', 'string', 'min:2', 'max:120'],
            'completed' => ['sometimes', 'required', 'boolean'],
            'priority'  => ['sometimes', 'required', 'string', 'in:low,medium,high'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('title')) {
            $this->merge(['title' => strip_tags($this->title)]);
        }
    }

    public function messages(): array
    {
        return [
            'title.min'       => 'Task title must be at least 2 characters.',
            'completed.boolean' => 'Completed must be true or false.',
            'priority.in'     => 'Priority must be low, medium, or high.',
        ];
    }
}
