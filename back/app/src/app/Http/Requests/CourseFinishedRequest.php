<?php

namespace App\Http\Requests;

use App\Models\CourseFinished;
use App\Services\CourseFinishedService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;

class CourseFinishedRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $courseFinishedService = App::make(CourseFinishedService::class);
        $courseFinished = null;

        if ($this->isMethod('post')) {
            return $this->user()->can('create', new CourseFinished($this->only('name', 'created_by')));
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $courseFinished = $courseFinishedService->getById($this->route('courses_finished'));
            return $this->user()->can('update', $courseFinished);
        } elseif ($this->isMethod('delete')) {
            $courseFinished = $courseFinishedService->getById($this->route('courses_finished'));
            return $this->user()->can('forceDelete', $courseFinished);
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
            'course_id' => 'required|exists:courses,id',
            'user_id' => 'required|exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'course_id.required' => 'The course ID field is required.',
            'course_id.exists' => 'The selected course ID is invalid.',
            'user_id.required' => 'The user ID field is required.',
            'user_id.exists' => 'The selected user ID is invalid.',
            'finished_at.required' => 'The finished at field is required.',
            'finished_at.date' => 'The finished at field must be a valid date.',
        ];
    }
}
