<?php

namespace App\Http\Requests;

use App\Models\Course;
use App\Services\CourseService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class CourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (!$this->user()) {
            return false;
        }

        $courseService = App::make(CourseService::class);
        $course = null;

        if ($this->isMethod('post')) {
            return $this->user()->can('create', new Course($this->only('name', 'created_by')));
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $course = $courseService->getById($this->route('course'));
            return $this->user()->can('update', $course);
        } elseif ($this->isMethod('delete')) {
            $course = $courseService->getById($this->route('course'));
            return $this->user()->can('forceDelete', $course);
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
            'name' => 'required|string|max:255|unique:courses,name',
            'average_rating' => 'nullable|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string|max:1000',
            'review_count' => 'nullable|integer|min:0',
            'created_by' => 'required|exists:admins,id',
            'updated_by' => 'required|exists:admins,id',
        ];
    }
    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The course name is required.',
            'name.unique' => 'This course name already exists.',
            'category.required' => 'The category is required.',
            'average_rating.numeric' => 'The average rating must be a number.',
            'average_rating.min' => 'The rating must be at least 0.',
            'review_count.integer' => 'The review count must be a valid integer.',
            'created_by.exists' => 'The creator must be a valid admin.',
            'updated_by.exists' => 'The updater must be a valid admin.',
        ];
    }

}
