<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConvocationSetting extends Model
{
    use HasFactory;

    protected $table = 'convocation_settings';

    protected $fillable = [
        'institution_name',
        'institution_tagline',
        'convocation_title',
        'slogan',
        'convocation_date',
        'convocation_date_formatted',
        'registration_deadline',
        'registration_deadline_formatted',
        'official_website',
        'portal_announcement',
        'priority_sessions',
        'provisional_sessions',
        'priority_notice',
        'provisional_notice',
        'base_registration_fee',
        'guest_fee_per_person',
        'max_guests_allowed',
        'gown_included_notice',
        'allowed_guest_relations',
        'bank_name',
        'secondary_bank',
        'account_title',
        'account_number',
        'iban',
        'branch_info',
    ];

    protected $casts = [
        'convocation_date'      => 'date',
        'registration_deadline' => 'date',
        'base_registration_fee' => 'decimal:2',
        'guest_fee_per_person'  => 'decimal:2',
        'max_guests_allowed'    => 'integer',
    ];

    /**
     * Singleton accessor for global current settings
     */
    public static function current(): self
    {
        $setting = static::first();
        if (!$setting) {
            $setting = static::create([
                'institution_name'                => 'Shahida Islam Medical Complex',
                'institution_tagline'             => 'Together for Excellence in Healthcare Education',
                'convocation_title'               => 'First Convocation 2026',
                'slogan'                          => 'A Proud Milestone in Our Journey',
                'convocation_date'                => '2026-11-28',
                'convocation_date_formatted'      => 'Saturday, 28 November 2026',
                'registration_deadline'           => '2026-11-15',
                'registration_deadline_formatted' => '15 November 2026',
                'official_website'                => 'https://simc.edu.pk',
                'portal_announcement'             => 'Bringing together the pioneering graduating batches of Shahida Islam Medical College (MBBS) and Shahida Islam Dental College (BDS).',
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
            ]);
        }
        return $setting;
    }

    /**
     * Priority sessions array
     */
    public function getPrioritySessionsListAttribute(): array
    {
        return array_map('trim', explode(',', $this->priority_sessions ?? '2021, 2022, 2023'));
    }

    /**
     * Provisional sessions array
     */
    public function getProvisionalSessionsListAttribute(): array
    {
        return array_map('trim', explode(',', $this->provisional_sessions ?? '2024'));
    }
}

