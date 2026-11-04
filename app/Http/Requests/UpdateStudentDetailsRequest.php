<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStudentDetailsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->user()?->id ?? $this->route('id') ?? $this->input('user_id');

        return [
            // Student Personal & Credentials
            'name'                 => ['required', 'string', 'max:255'],
            'email'                => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'contact_no'           => ['required', 'string', 'min:10', 'max:20'],
            'emergency_contact_no' => ['required', 'string', 'min:10', 'max:20'],
            'cnic'                 => ['required', 'string', 'min:13', 'max:20'],
            'roll_no'              => ['required', 'string', 'max:50'],
            'father_name'          => ['required', 'string', 'max:255'],

            // Academic Info
            'department'           => ['required', 'string', 'in:MBBS,BDS,Pharm-D,Nursing,DPT'],
            'session'              => ['required', 'string', 'max:50'],
            'class'                => ['required', 'string', 'max:50'],

            // Structured Residential Address
            'house_no'             => ['required', 'string', 'max:255'],
            'street_address'       => ['required', 'string', 'max:255'],
            'area'                 => ['required', 'string', 'max:255'],
            'city'                 => ['required', 'string', 'max:100'],
            'province'             => ['required', 'string', 'max:100'],
            'address'              => ['nullable', 'string'],

            // University and Council
            'uhs_registration_no'  => ['required', 'string', 'max:100'],
            'council_type'         => ['required', 'string', 'in:PMDC,PNC,PCP,AHC'],
            'pmdc_registration_no' => ['required', 'string', 'max:100'],

            // Accompanying Guests
            'guests_count'         => ['required', 'integer', 'in:0,1,2'],
            'guest1_name'          => ['required_if:guests_count,1,2', 'nullable', 'string', 'max:255'],
            'guest1_cnic'          => ['required_if:guests_count,1,2', 'nullable', 'string', 'min:13', 'max:20'],
            'guest1_contact_no'    => ['required_if:guests_count,1,2', 'nullable', 'string', 'min:10', 'max:20'],
            'guest2_name'          => ['required_if:guests_count,2', 'nullable', 'string', 'max:255'],
            'guest2_cnic'          => ['required_if:guests_count,2', 'nullable', 'string', 'min:13', 'max:20'],
            'guest2_contact_no'    => ['required_if:guests_count,2', 'nullable', 'string', 'min:10', 'max:20'],

            // Distinctions & Positions
            'positions_data'       => ['nullable'],
            'positions_summary'    => ['nullable', 'string'],
        ];
    }
}

