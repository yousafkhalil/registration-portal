<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Student Personal & Credentials
            'name'                 => ['required', 'string', 'max:255'],
            'email'                => ['required', 'email', 'max:255', 'unique:users,email'],
            'password'             => ['required', 'string', 'min:6', 'confirmed'],
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

    public function messages(): array
    {
        return [
            'name.required'                 => 'Student Full Name is mandatory.',
            'email.required'                => 'Email Address is required for account login.',
            'email.unique'                  => 'This email address is already registered.',
            'password.required'             => 'Please provide a secure password.',
            'password.confirmed'            => 'Password confirmation does not match.',
            'contact_no.required'           => 'Contact / Mobile number is mandatory.',
            'emergency_contact_no.required' => 'Emergency Contact number is mandatory.',
            'cnic.required'                 => 'CNIC / B-Form number is mandatory.',
            'roll_no.required'              => 'Student Roll Number is mandatory.',
            'father_name.required'          => 'Father Name is mandatory.',
            'department.required'           => 'Degree Program / Department selection is mandatory.',
            'session.required'              => 'Admission Year is mandatory.',
            'class.required'                => 'Graduation Year is mandatory.',
            'house_no.required'             => 'House / Flat / Building No. is mandatory.',
            'street_address.required'       => 'Street / Road / Sector is mandatory.',
            'area.required'                 => 'Area / Locality / Mohallah is mandatory.',
            'city.required'                 => 'City / District is mandatory.',
            'province.required'             => 'Province / Territory selection is mandatory.',
            'uhs_registration_no.required'  => 'University Registration Number is mandatory.',
            'council_type.required'         => 'Council type selection is mandatory.',
            'pmdc_registration_no.required' => 'Council Registration Number is mandatory.',
            'guest1_name.required_if'       => 'Guest 1 Full Name is required when 1 or more guests are selected.',
            'guest1_cnic.required_if'       => 'Guest 1 CNIC is required when 1 or more guests are selected.',
            'guest2_name.required_if'       => 'Guest 2 Full Name is required when 2 guests are selected.',
            'guest2_cnic.required_if'       => 'Guest 2 CNIC is required when 2 guests are selected.',
        ];
    }
}

