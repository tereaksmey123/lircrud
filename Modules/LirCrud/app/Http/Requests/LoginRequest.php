<?php

namespace Modules\LirCrud\app\Http\Requests;

use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        // if (app()->isLocal()) {
            return ['username' => 'required|min:3', 'password' => 'required|integer|min:5'];
        // }
        
        return [
            'username' => 'required',
            'password' => [
                'required',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ]
            //
        ];
    }

    /**
     * Prefered to define jsRules
     *
     * Not every rule on server is needed to apply on client side
     * Instead of let the system guessing and replacing
     */
    public function jsRules()
    {
        return [
            'username' => [
                ['required' => true,
                'message' => __('validation.required', ['attribute' => 'username'])]
            ],
            'password' => [
                ['required' => true,
                'message' => __('validation.required', ['attribute' => 'password'])],
                ['type' => 'string', 'min' => 3,
                'message' => __('validation.min.string', ['attribute' => 'password', 'min' => 3])]
            ]
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
