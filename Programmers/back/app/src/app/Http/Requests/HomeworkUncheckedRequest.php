<?php

namespace App\Http\Requests;

use App\Models\ChallengeUnchecked;
use App\Services\ChallengeUncheckedService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;

class HomeworkUncheckedRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $homeworkUncheckedService = App::make(ChallengeUncheckedService::class);
        $homeworkUnchecked = null;

        if ($this->isMethod('post')) {
            return $this->user()->can('create', new ChallengeUnchecked($this->only('challenge_id')));
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $homeworkUnchecked = $homeworkUncheckedService->getById($this->route('homeworks_unchecked'));
            return $this->user()->can('update', $homeworkUnchecked);
        } elseif ($this->isMethod('delete')) {
            $homeworkUnchecked = $homeworkUncheckedService->getById($this->route('homeworks_unchecked'));
            return $this->user()->can('forceDelete', $homeworkUnchecked);
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
            'homework_id' => 'required|exists:homeworks,id',
            'user_id' => 'required|exists:users,id',
            'submission_link' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'homework_id.required' => 'The homework ID field is required.',
            'homework_id.exists' => 'The selected homework ID does not exist.',

            'user_id.required' => 'The user ID field is required.',
            'user_id.exists' => 'The selected user ID does not exist.',

            'submission_link.required' => 'The link to submission is required.',
            'submission_link.string' => 'The link to submission must be a valid string.',
            'submission_link.max' => 'The link to submission may not be greater than 255 characters.',
        ];
    }
}
