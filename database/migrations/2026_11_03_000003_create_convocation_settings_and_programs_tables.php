<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Convocation Master Settings Table
        Schema::create('convocation_settings', function (Blueprint $table) {
            $table->id();
            $table->string('institution_name')->default('Shahida Islam Medical Complex');
            $table->string('institution_tagline')->nullable()->default('Together for Excellence in Healthcare Education');
            $table->string('convocation_title')->default('First Convocation 2026');
            $table->string('slogan')->nullable()->default('A Proud Milestone in Our Journey');
            $table->date('convocation_date')->default('2026-11-28');
            $table->string('convocation_date_formatted')->default('Saturday, 28 November 2026');
            $table->date('registration_deadline')->default('2026-11-15');
            $table->string('registration_deadline_formatted')->default('15 November 2026');
            $table->string('official_website')->default('https://simc.edu.pk');
            $table->text('portal_announcement')->nullable();

            // Priority and Eligibility Rules
            $table->string('priority_sessions')->default('2021, 2022, 2023');
            $table->string('provisional_sessions')->default('2024');
            $table->text('priority_notice')->nullable();
            $table->text('provisional_notice')->nullable();

            // Dynamic Fee Structure
            $table->decimal('base_registration_fee', 10, 2)->default(15000.00);
            $table->decimal('guest_fee_per_person', 10, 2)->default(5000.00);
            $table->integer('max_guests_allowed')->default(2);
            $table->string('gown_included_notice')->default('including convocation gown');
            $table->string('allowed_guest_relations')->default('Strictly immediate family members only: parents and siblings');

            // Bank Account Configurations
            $table->string('bank_name')->default('The Bank of Punjab (BOP)');
            $table->string('secondary_bank')->nullable()->default('Habib Bank Limited (HBL)');
            $table->string('account_title')->default('Shahida Islam Medical Complex - Convocation Fund');
            $table->string('account_number')->default('00100458920001');
            $table->string('iban')->default('PK36BOPB00100458920001');
            $table->string('branch_info')->default('Any Online Branch Nationwide or Raast / 1Link');

            $table->timestamps();
        });

        // 2. Convocation Focal Persons Table
        Schema::create('convocation_focal_persons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('designation')->nullable()->default('Convocation Focal Person');
            $table->string('mobile');
            $table->string('email')->nullable();
            $table->integer('sort_order')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 3. Academic Programs & Degree Departments Table
        Schema::create('academic_programs', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // MBBS, BDS, Pharm-D, Nursing, DPT
            $table->string('name');           // Bachelor of Medicine & Bachelor of Surgery
            $table->string('college_name');   // Shahida Islam Medical College
            $table->string('degree_title');   // MBBS
            $table->integer('total_profs')->default(5);
            $table->json('profs_list');       // ["1st Prof", "2nd Prof", ...]
            $table->string('council_type')->default('PMDC');
            $table->string('council_placeholder')->nullable()->default('54321-P');
            $table->integer('sort_order')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_programs');
        Schema::dropIfExists('convocation_focal_persons');
        Schema::dropIfExists('convocation_settings');
    }
};

