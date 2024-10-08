<?php

namespace App\Http\Requests;

use App\Models\CourseReview;
use App\Services\CourseReviewService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class CourseReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $courseReviewService = App::make(CourseReviewService::class);
        $courseReview = null;

        if ($this->isMethod('post')) {
            return $this->user()->can('create', new CourseReview($this->only('course_id', 'user_id')));
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $courseReview = $courseReviewService->getById($this->route('courses_review'));
            return $this->user()->can('update', $courseReview);
        } elseif ($this->isMethod('delete')) {
            $courseReview = $courseReviewService->getById($this->route('courses_review'));
            return $this->user()->can('forceDelete', $courseReview);
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
            'content' => 'required|string|max:255',
            'course_id' => 'required|integer|exists:courses,id',
            'user_id' => 'required|integer|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
        ];
    }
}
