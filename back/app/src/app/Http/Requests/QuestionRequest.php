<?php

namespace App\Http\Requests;

use App\Models\Question;
use App\Services\QuestionService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;

class QuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $questionService = App::make(QuestionService::class);
        $question = null;

        if ($this->isMethod('get')) {
            if ($this->routeIs('questions.index')) {
                return $this->user()->can('viewAny', Question::class);
            }

            if ($this->routeIs('questions.show')) {
                $question = $questionService->getById($this->route('question'));
                return $this->user()->can('view', $question);
            } elseif ($this->isMethod('post')) {
                return $this->user()->can('create', new Question($this->only('name')));
            } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
                $question = $questionService->getById($this->route('question'));
                return $this->user()->can('update', $question);
            } elseif ($this->isMethod('delete')) {
                $question = $questionService->getById($this->route('question'));
                return $this->user()->can('forceDelete', $question);
            }
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
            'order' => 'required|integer|between:1,255',
            'name' => 'required|string|max:255',
            'matter' => 'required|string|max:255',
            'answers' => 'required|array|max:255',
            'lesson_id' => 'required|exists:lessons,id',
        ];
    }


    public function messages(): array
    {
        return [
            'order.required' => 'The order field is required.',
            'order.integer' => 'The order must be an integer.',
            'order.between' => 'The order must be between 1 and 255.',
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'matter.required' => 'The matter field is required.',
            'matter.string' => 'The matter must be a string.',
            'matter.max' => 'The matter may not be greater than 255 characters.',
            'answers.required' => 'The answers field is required.',
            'answers.string' => 'The answers must be a string.',
            'answers.max' => 'The answers may not be greater than 255 characters.',
            'lesson_id.required' => 'The lesson ID field is required.',
            'lesson_id.exists' => 'The selected lesson ID is invalid.',
        ];
    }
}
