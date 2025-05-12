<?php

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GoogleSignInMobileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
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
            'providerAccountId'     => ['required', 'string'],
            'providerEmail'         => ['required', 'email'],
            'providerAccountName'   => ['required', 'string'],
            'providerPhotoUrl'      => ['nullable', 'string'],
            'providerName'          => ['required', 'string'],
        ];
    }
}
