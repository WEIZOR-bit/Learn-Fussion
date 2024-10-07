<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $userService = App::make(UserService::class);
        $user = null;


        if ($this->isMethod('post')) {
            return $this->user()->can('create', new User($this->only('name', 'email')));
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $user = $userService->getById($this->route('user'));
            return $this->user()->can('update', $user);
        } elseif ($this->isMethod('delete')) {
            $user = $userService->getById($this->route('user'));
            return $this->user()->can('forceDelete', $user);
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
        $userId = $this->route()->parameter('user');
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                $userId ? 'unique:users,email,' . $userId : 'unique:users,email',
            ],
            'password' => $this->isMethod('post') ? 'required|string|min:8' : 'nullable|string|min:8',
            'mastery_level' => 'nullable|integer|min:0',
            'hearts' => 'nullable|integer|min:0',
            'mastery_tag' => 'nullable|string|max:255',
            'started_streak_at' => 'nullable|date',
            'last_active_at' => 'nullable|date',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email is already in use.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 8 characters long.',
            'mastery_level.integer' => 'Mastery level must be an integer.',
            'hearts.integer' => 'Hearts must be an integer.',
            'started_streak_at.date' => 'Started streak must be a valid date.',
            'last_active_at.date' => 'Last active must be a valid date.',
        ];
    }
}
