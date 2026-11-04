<?php

namespace Database\Seeders;

use App\Models\AcademicProgram;
use App\Models\ConvocationFocalPerson;
use App\Models\ConvocationSetting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create or update Super Admin
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name'                 => 'Super Admin',
                'password'             => Hash::make('admin123'),
                'role'                 => 'admin',
                'department'           => 'Administration',
                'contact_no'           => '03001234567',
                'emergency_contact_no' => '03007654321',
                'cnic'                 => '3520111111111',
                'address'              => 'Convocation Control Cell, Administration Block',
                'active'               => 'Y',
            ]
        );

        // 2. Convocation Master Settings
        ConvocationSetting::updateOrCreate(
            ['id' => 1],
            [
                'institution_name'                => 'Shahida Islam Medical Complex',
                'institution_tagline'             => 'Together for Excellence in Healthcare Education',
                'convocation_title'               => 'First Convocation 2026',
                'slogan'                          => 'A Proud Milestone in Our Journey',
                'convocation_date'                => '2026-11-28',
                'convocation_date_formatted'      => 'Saturday, 28 November 2026',
                'registration_deadline'           => '2026-11-15',
                'registration_deadline_formatted' => '15 November 2026',
                'official_website'                => 'https://simc.edu.pk',
                'portal_announcement'             => 'Bringing together the pioneering graduating batches of Shahida Islam Medical College (MBBS) and Shahida Islam Dental College (BDS) to celebrate their academic achievements and professional journeys.',
                'priority_sessions'               => '2021, 2022, 2023',
                'provisional_sessions'            => '2024',
                'priority_notice'                 => 'All graduates who passed their Final Professional Examinations (Annual or Supplementary) in the 2021, 2022, or 2023 examination sessions will be given priority and the opportunity to participate in the First Convocation 2026, upon completion of the required registration formalities.',
                'provisional_notice'              => 'Graduates of both MBBS and BDS who passed their Final Professional Examinations (Annual or Supplementary) in the 2024 examination session are invited to register provisionally. Their participation will depend on seat availability after graduates from the earlier three sessions have been accommodated.',
                'base_registration_fee'           => 15000.00,
                'guest_fee_per_person'            => 5000.00,
                'max_guests_allowed'              => 2,
                'gown_included_notice'            => 'including convocation gown',
                'allowed_guest_relations'         => 'Strictly immediate family members only: parents and siblings. Other relatives or accompanying persons will not be permitted.',
                'bank_name'                       => 'The Bank of Punjab (BOP)',
                'secondary_bank'                  => 'Habib Bank Limited (HBL)',
                'account_title'                   => 'Shahida Islam Medical Complex - Convocation Fund',
                'account_number'                  => '00100458920001',
                'iban'                            => 'PK36BOPB00100458920001',
                'branch_info'                     => 'Any Online Branch Nationwide or Raast / 1Link',
            ]
        );

        // 3. Focal Persons
        ConvocationFocalPerson::updateOrCreate(
            ['mobile' => '+92 300 3180057'],
            [
                'name'        => 'Dr. Talha Khalil',
                'designation' => 'Convocation Focal Person',
                'sort_order'  => 1,
                'is_active'   => true,
            ]
        );

        ConvocationFocalPerson::updateOrCreate(
            ['mobile' => '+92 301 8734750'],
            [
                'name'        => 'Mr. Shabbir Malik',
                'designation' => 'Convocation Focal Person',
                'sort_order'  => 2,
                'is_active'   => true,
            ]
        );

        // 4. Academic Programs & Colleges
        $programs = [
            [
                'code'                => 'MBBS',
                'name'                => 'Bachelor of Medicine and Bachelor of Surgery',
                'college_name'        => 'Shahida Islam Medical College (MBBS)',
                'degree_title'        => 'MBBS',
                'total_profs'         => 5,
                'profs_list'          => ['1st Prof', '2nd Prof', '3rd Prof', '4th Prof', 'Final Prof'],
                'council_type'        => 'PMDC',
                'council_placeholder' => '54321-P',
                'sort_order'          => 1,
            ],
            [
                'code'                => 'BDS',
                'name'                => 'Bachelor of Dental Surgery',
                'college_name'        => 'Shahida Islam Dental College (BDS)',
                'degree_title'        => 'BDS',
                'total_profs'         => 4,
                'profs_list'          => ['1st Prof', '2nd Prof', '3rd Prof', 'Final Prof'],
                'council_type'        => 'PMDC',
                'council_placeholder' => '12345-D',
                'sort_order'          => 2,
            ],
            [
                'code'                => 'Pharm-D',
                'name'                => 'Doctor of Pharmacy',
                'college_name'        => 'Faculty of Pharmacy',
                'degree_title'        => 'Pharm-D',
                'total_profs'         => 5,
                'profs_list'          => ['1st Prof', '2nd Prof', '3rd Prof', '4th Prof', '5th Prof'],
                'council_type'        => 'PCP',
                'council_placeholder' => '12345-PCP',
                'sort_order'          => 3,
            ],
            [
                'code'                => 'Nursing',
                'name'                => 'Bachelor of Science in Nursing',
                'college_name'        => 'College of Nursing',
                'degree_title'        => 'BS Nursing',
                'total_profs'         => 4,
                'profs_list'          => ['1st Prof', '2nd Prof', '3rd Prof', '4th Prof'],
                'council_type'        => 'PNC',
                'council_placeholder' => '12345-PNC',
                'sort_order'          => 4,
            ],
            [
                'code'                => 'DPT',
                'name'                => 'Doctor of Physical Therapy',
                'college_name'        => 'Department of Physical Therapy',
                'degree_title'        => 'DPT',
                'total_profs'         => 5,
                'profs_list'          => ['1st Prof', '2nd Prof', '3rd Prof', '4th Prof', '5th Prof'],
                'council_type'        => 'AHC',
                'council_placeholder' => '12345-AHC',
                'sort_order'          => 5,
            ],
        ];

        foreach ($programs as $prog) {
            AcademicProgram::updateOrCreate(
                ['code' => $prog['code']],
                $prog
            );
        }
    }
}
