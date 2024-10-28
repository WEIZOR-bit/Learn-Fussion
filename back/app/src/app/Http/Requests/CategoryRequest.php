<?php

namespace App\Http\Requests;

use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $categoryService = App::make(CategoryService::class);
        $category = null;

        if ($this->isMethod('post')) {
            return $this->user()->can('create', new Category($this->only('name', 'created_by')));
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $category = $categoryService->getById($this->route('categories'));
            return $this->user()->can('update', $category);
        } elseif ($this->isMethod('delete')) {
            $category = $categoryService->getById($this->route('categories'));
            return $this->user()->can('forceDelete', $category);
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:30|unique:categories,name'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.'
        ];
    }
}
