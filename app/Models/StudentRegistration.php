<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentRegistration extends Model
{
    use HasFactory;

    protected $table = 'student_registrations';

    protected $fillable = [
        'user_id',
        'roll_no',
        'name',
        'father_name',
        'department',
        'session',
        'class',
        'uhs_registration_no',
        'council_type',
        'pmdc_registration_no',
        'house_no',
        'street_address',
        'area',
        'city',
        'province',
        'address',
        'contact_no',
        'emergency_contact_no',
        'cnic',
        'email',
        'guests_count',
        'guest1_name',
        'guest1_cnic',
        'guest1_contact_no',
        'guest2_name',
        'guest2_cnic',
        'guest2_contact_no',
        'positions_data',
        'positions_summary',
        'status',
        'challan_no',
        'fee_amount',
        'payment_status',
        'payment_method',
        'paid_amount',
        'paid_at',
        'bank_name',
        'transaction_id',
        'receipt_path',
        'payment_remarks',
        'due_date',
        'verified_by_user_id',
        'verified_at',
        'rejection_reason',
        'admin_notes',
    ];

    protected $casts = [
        'positions_data' => 'array',
        'guests_count'   => 'integer',
        'fee_amount'     => 'decimal:2',
        'paid_amount'    => 'decimal:2',
        'paid_at'        => 'datetime',
        'verified_at'    => 'datetime',
        'due_date'       => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by_user_id');
    }

    /**
     * Calculate fee dynamically from database settings
     */
    public static function calculateFee(int $guestsCount): int
    {
        try {
            $settings = ConvocationSetting::current();
            $base = (int)($settings->base_registration_fee ?? 15000);
            $perGuest = (int)($settings->guest_fee_per_person ?? 5000);
            return $base + ($guestsCount * $perGuest);
        } catch (\Exception $e) {
            return 15000 + ($guestsCount * 5000);
        }
    }

    /**
     * Generate unique challan number: CHL-2026-00045
     */
    public static function generateChallanNo(?int $seed = null): string
    {
        $year = date('Y');
        $num = $seed ?? mt_rand(1000, 99999);
        return 'CHL-' . $year . '-' . str_pad((string)$num, 5, '0', STR_PAD_LEFT);
    }

    /**
     * Breakdown of fee dynamically from database settings
     */
    public function getFeeBreakdownAttribute(): array
    {
        try {
            $settings = ConvocationSetting::current();
            $baseFee = (float)($settings->base_registration_fee ?? 15000);
            $guestFeePerPerson = (float)($settings->guest_fee_per_person ?? 5000);
        } catch (\Exception $e) {
            $baseFee = 15000;
            $guestFeePerPerson = 5000;
        }

        $guestsCount = (int)$this->guests_count;
        $guestsTotal = $guestsCount * $guestFeePerPerson;
        $standardTotal = $baseFee + $guestsTotal;

        // If unpaid, fee is dynamically calculated: base + (guests * perGuest)
        // Only if an explicit discount/waiver/concession is recorded in admin_notes, honor an overridden fee_amount
        $hasCustomWaiver = !empty($this->admin_notes) && preg_match('/(discount|waiver|concession|custom fee)/i', $this->admin_notes);

        if ($this->payment_status === 'paid' && $this->fee_amount > 0) {
            $total = (float)$this->fee_amount;
            $baseFee = max(0, $total - $guestsTotal);
        } elseif ($hasCustomWaiver && $this->fee_amount > 0) {
            // Admin gave an explicit custom concession/waiver recorded in notes
            $total = (float)$this->fee_amount;
            $baseFee = max(0, $total - $guestsTotal);
        } else {
            // Standard dynamic calculation: Base Fee + (Guests * Guest Fee)
            $total = $standardTotal;
        }

        return [
            'base_registration_fee' => $baseFee,
            'guest_fee_per_person'  => $guestFeePerPerson,
            'guests_count'          => $guestsCount,
            'guests_total_fee'      => $guestsTotal,
            'total_fee'             => $total,
            'formatted_total'       => number_format($total),
        ];
    }

    /**
     * Formatted CNIC with dashes: 35202-1234567-1
     */
    public function getCnicFormattedAttribute(): ?string
    {
        if (empty($this->cnic)) return null;
        $clean = preg_replace('/[^0-9]/', '', $this->cnic);
        if (strlen($clean) === 13) {
            return substr($clean, 0, 5) . '-' . substr($clean, 5, 7) . '-' . substr($clean, 12, 1);
        }
        return $this->cnic;
    }

    /**
     * Formatted Guest 1 CNIC
     */
    public function getGuest1CnicFormattedAttribute(): ?string
    {
        if (empty($this->guest1_cnic)) return null;
        $clean = preg_replace('/[^0-9]/', '', $this->guest1_cnic);
        if (strlen($clean) === 13) {
            return substr($clean, 0, 5) . '-' . substr($clean, 5, 7) . '-' . substr($clean, 12, 1);
        }
        return $this->guest1_cnic;
    }

    /**
     * Formatted Guest 2 CNIC
     */
    public function getGuest2CnicFormattedAttribute(): ?string
    {
        if (empty($this->guest2_cnic)) return null;
        $clean = preg_replace('/[^0-9]/', '', $this->guest2_cnic);
        if (strlen($clean) === 13) {
            return substr($clean, 0, 5) . '-' . substr($clean, 5, 7) . '-' . substr($clean, 12, 1);
        }
        return $this->guest2_cnic;
    }
}
