<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAdmissionRequest extends FormRequest
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
            // Basic Information
            'semester_id' => ['required', 'exists:semesters,id'],
            'department_id' => ['required', 'exists:departments,id'],
            'program_id' => [
                'required',
                'exists:programs,id',
                Rule::exists('programs', 'id')->where('department_id', $this->department_id),
            ],
            'full_name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'hear_about_us' => ['nullable', 'string', 'in:Website,Social Media,Friend/Relative,Advertisement,Other'],
            'father_name' => ['nullable', 'string', 'max:255'],
            'mother_name' => ['nullable', 'string', 'max:255'],
            'assisted_by' => ['nullable', 'string', 'max:255'],

            // SSC Results (required)
            'ssc_roll' => ['required', 'string', 'max:50'],
            'ssc_registration_no' => ['required', 'string', 'max:50'],
            'ssc_gpa' => ['required', 'numeric', 'min:0', 'max:5'],
            'ssc_grade' => ['nullable', 'string', 'max:10'],
            'ssc_board' => ['nullable', 'string', 'max:100'],
            'ssc_passing_year' => ['nullable', 'integer'],

            // HSC Results (optional)
            'hsc_roll' => ['nullable', 'string', 'max:50'],
            'hsc_registration_no' => ['nullable', 'string', 'max:50'],
            'hsc_gpa' => ['nullable', 'numeric', 'min:0', 'max:5'],
            'hsc_grade' => ['nullable', 'string', 'max:10'],
            'hsc_board' => ['nullable', 'string', 'max:100'],
            'hsc_passing_year' => ['nullable', 'integer'],

            // Honors Results (optional)
            'honors_roll' => ['nullable', 'string', 'max:50'],
            'honors_registration_no' => ['nullable', 'string', 'max:50'],
            'honors_gpa' => ['nullable', 'numeric', 'min:0', 'max:4'],
            'honors_grade' => ['nullable', 'string', 'max:50'],
            'honors_board' => ['nullable', 'string', 'max:100'],
            'honors_passing_year' => ['nullable', 'integer'],
            'honors_institution' => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'program_id.exists' => 'The selected program does not belong to the selected department.',
            'ssc_gpa.max' => 'SSC GPA must not be greater than 5.00.',
            'hsc_gpa.max' => 'HSC GPA must not be greater than 5.00.',
            'honors_gpa.max' => 'Honors GPA must not be greater than 4.00.',
        ];
    }
}
