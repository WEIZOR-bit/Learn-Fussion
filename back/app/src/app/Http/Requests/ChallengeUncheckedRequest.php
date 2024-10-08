<?php

namespace App\Http\Requests;

use App\Models\ChallengeUnchecked;
use App\Services\ChallengeUncheckedService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;

class ChallengeUncheckedRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $challengeUncheckedService = App::make(ChallengeUncheckedService::class);
        $challengeUnchecked = null;

        if ($this->isMethod('post')) {
            return $this->user()->can('create', new ChallengeUnchecked($this->only('challenge_id')));
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $challengeUnchecked = $challengeUncheckedService->getById($this->route('challenges_unchecked'));
            return $this->user()->can('update', $challengeUnchecked);
        } elseif ($this->isMethod('delete')) {
            $challengeUnchecked = $challengeUncheckedService->getById($this->route('challenges_unchecked'));
            return $this->user()->can('forceDelete', $challengeUnchecked);
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
            'challenge_id' => 'required|exists:challenges,id',
            'user_id' => 'required|exists:users,id',
            'submission_link' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'challenge_id.required' => 'The challenge ID field is required.',
            'challenge_id.exists' => 'The selected challenge ID does not exist.',

            'user_id.required' => 'The user ID field is required.',
            'user_id.exists' => 'The selected user ID does not exist.',

            'submission_link.required' => 'The link to submission is required.',
            'submission_link.string' => 'The link to submission must be a valid string.',
            'submission_link.max' => 'The link to submission may not be greater than 255 characters.',
        ];
    }
}
