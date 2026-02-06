<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCertificateRequest extends FormRequest
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
            'roll' => ['required', 'string', 'max:255'],
            'registration_number' => ['required', 'string', 'max:255'],
            'passing_year' => [
                'required',
                'integer',
                'min:1900',
                'max:2100',
                Rule::unique('certificates')->where(function ($query) {
                    return $query->where('roll', $this->roll)
                        ->where('registration_number', $this->registration_number)
                        ->where('passing_year', $this->passing_year);
                }),
            ],
            'name' => ['required', 'string', 'max:255'],
            'father_name' => ['nullable', 'string', 'max:255'],
            'mother_name' => ['nullable', 'string', 'max:255'],
            'program' => ['required', 'string', 'max:255'],
            'batch' => ['nullable', 'string', 'max:255'],
            'session' => ['nullable', 'string', 'max:255'],
            'cgpa_or_class' => ['nullable', 'string', 'max:255'],
        ];
    }
}
