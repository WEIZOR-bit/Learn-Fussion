<?php

namespace App\Http\Requests;

use App\Models\LessonFinished;
use App\Services\LessonFinishedService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;

class LessonFinishedRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $lessonFinishedService = App::make(LessonFinishedService::class);
        $lessonFinished = null;

        if ($this->isMethod('post')) {
            return $this->user()->can('create', new LessonFinished($this->only('name')));
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $lessonFinished = $lessonFinishedService->getById($this->route('lessons_finished'));
            return $this->user()->can('update', $lessonFinished);
        } elseif ($this->isMethod('delete')) {
            $lessonFinished = $lessonFinishedService->getById($this->route('lessons_finished'));
            return $this->user()->can('forceDelete', $lessonFinished);
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
            'lesson_id' => 'required|exists:lessons,id',
            'user_id' => 'required|exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'lesson_id.required' => 'The lesson ID field is required.',
            'lesson_id.exists' => 'The selected lesson ID is invalid.',
            'user_id.required' => 'The user ID field is required.',
            'user_id.exists' => 'The selected user ID is invalid.',
            'finished_at.required' => 'The finished at field is required.',
            'finished_at.date' => 'The finished at field must be a valid date.',
        ];
    }
}
