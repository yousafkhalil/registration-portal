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

    protected function prepareForValidation(): void
    {
        $merge = [];
        if ($this->has('contact_no')) {
            $merge['contact_no'] = preg_replace('/[^0-9]/', '', (string)$this->contact_no);
        }
        if ($this->has('emergency_contact_no')) {
            $merge['emergency_contact_no'] = preg_replace('/[^0-9]/', '', (string)$this->emergency_contact_no);
        }
        if ($this->filled('guest1_contact_no')) {
            $merge['guest1_contact_no'] = preg_replace('/[^0-9]/', '', (string)$this->guest1_contact_no);
        }
        if ($this->filled('guest2_contact_no')) {
            $merge['guest2_contact_no'] = preg_replace('/[^0-9]/', '', (string)$this->guest2_contact_no);
        }
        $this->merge($merge);
    }

    public function rules(): array
    {
        $userId = $this->user()?->id ?? $this->route('id') ?? $this->input('user_id');

        return [
            // Student Personal & Credentials
            'name'                 => ['required', 'string', 'max:255'],
            'email'                => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'contact_no'           => ['required', 'string', 'size:11', 'regex:/^[0-9]{11}$/'],
            'emergency_contact_no' => ['required', 'string', 'size:11', 'regex:/^[0-9]{11}$/'],
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
            'guest1_contact_no'    => ['required_if:guests_count,1,2', 'nullable', 'string', 'size:11', 'regex:/^[0-9]{11}$/'],
            'guest2_name'          => ['required_if:guests_count,2', 'nullable', 'string', 'max:255'],
            'guest2_cnic'          => ['required_if:guests_count,2', 'nullable', 'string', 'min:13', 'max:20'],
            'guest2_contact_no'    => ['required_if:guests_count,2', 'nullable', 'string', 'size:11', 'regex:/^[0-9]{11}$/'],

            // Distinctions & Positions
            'positions_data'       => ['nullable'],
            'positions_summary'    => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'contact_no.required'           => 'Contact / Mobile number is mandatory.',
            'contact_no.regex'              => 'Contact / Mobile number must be exactly 11 digits (e.g. 03001234567).',
            'emergency_contact_no.required' => 'Emergency Contact number is mandatory.',
            'emergency_contact_no.regex'    => 'Emergency Contact number must be exactly 11 digits (e.g. 03007654321).',
            'guest1_contact_no.regex'       => 'Guest 1 Contact number must be exactly 11 digits (e.g. 03001234567).',
            'guest2_contact_no.regex'       => 'Guest 2 Contact number must be exactly 11 digits (e.g. 03217654321).',
        ];
    }
}

