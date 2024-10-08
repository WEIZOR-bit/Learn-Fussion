<?php

namespace App\Http\Requests;

use App\Models\Challenge;
use App\Services\ChallengeService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;

class ChallengeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $challengeService = App::make(ChallengeService::class);
        $challenge = null;

        if ($this->isMethod('post')) {
            return $this->user()->can('create', new Challenge($this->only('name', 'created_by')));
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $challenge = $challengeService->getById($this->route('challenge'));
            return $this->user()->can('update', $challenge);
        } elseif ($this->isMethod('delete')) {
            $challenge = $challengeService->getById($this->route('challenge'));
            return $this->user()->can('forceDelete', $challenge);
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'reward' => 'required|integer|min:1|max:255',
            'created_by' => 'required|exists:admins,id',
            'updated_by' => 'required|exists:admins,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 255 characters.',

            'description.string' => 'The description must be a string.',
            'description.max' => 'The description may not be greater than 255 characters.',

            'reward.required' => 'The reward field is required.',
            'reward.integer' => 'The reward must be an integer.',
            'reward.min' => 'The reward must be at least 1.',
            'reward.max' => 'The reward may not be greater than 255.',

            'created_by.required' => 'The created_by field is required.',
            'created_by.exists' => 'The selected created_by admin does not exist.',

            'updated_by.required' => 'The updated_by field is required.',
            'updated_by.exists' => 'The selected updated_by admin does not exist.',
        ];
    }
}
