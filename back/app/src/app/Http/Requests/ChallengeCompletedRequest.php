<?php

namespace App\Http\Requests;

use App\Models\ChallengeCompleted;
use App\Services\ChallengeCompletedService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;

class ChallengeCompletedRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $challengeCompletedService = App::make(ChallengeCompletedService::class);
        $challengeCompleted = null;

        if ($this->isMethod('post')) {
            return $this->user()->can('create', new ChallengeCompleted($this->only('challenge_id')));
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $challengeCompleted = $challengeCompletedService->getById($this->route('challenges_completed'));
            return $this->user()->can('update', $challengeCompleted);
        } elseif ($this->isMethod('delete')) {
            $challengeCompleted = $challengeCompletedService->getById($this->route('challenges_completed'));
            return $this->user()->can('forceDelete', $challengeCompleted);
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
            'challenge_id' => 'required|integer|exists:challenges,id',
            'user_id' => 'required|integer|exists:users,id',
            'checked_by' => 'required|integer|exists:admins,id',

        ];
    }

    public function messages(): array
    {
        return [
            'challenge_id.required' => 'The challenge ID is required.',
            'challenge_id.exists' => 'The selected challenge ID does not exist.',

            'user_id.required' => 'The user ID is required.',
            'user_id.exists' => 'The selected user ID does not exist.',

            'checked_by.required' => 'The checked_by field is required.',
            'checked_by.exists' => 'The selected admin (checked_by) does not exist.',
        ];
    }
}
