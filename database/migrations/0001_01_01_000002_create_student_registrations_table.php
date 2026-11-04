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
        Schema::create('student_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('roll_no', 50)->nullable()->index();
            $table->string('name');
            $table->string('father_name')->nullable();
            $table->string('department', 50)->nullable()->index(); // MBBS, BDS, Pharm-D, Nursing, DPT
            $table->string('session', 50)->nullable(); // Admission Year
            $table->string('class', 50)->nullable();   // Graduation Year
            $table->string('uhs_registration_no', 100)->nullable()->index(); // e.g. 2022-uhs-001
            $table->string('council_type', 30)->nullable(); // PMDC, PNC, PCP, AHC
            $table->string('pmdc_registration_no', 100)->nullable(); // Council Reg No
            
            // Structured Address Fields
            $table->string('house_no')->nullable();
            $table->string('street_address')->nullable();
            $table->string('area')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('province', 100)->nullable();
            $table->text('address')->nullable(); // Combined full string

            // Contact Information
            $table->string('contact_no', 30)->nullable();
            $table->string('emergency_contact_no', 30)->nullable();
            $table->string('cnic', 30)->nullable();
            $table->string('email')->nullable();

            // Accompanying Guests (Max 2 Allowed)
            $table->integer('guests_count')->default(0);
            $table->string('guest1_name')->nullable();
            $table->string('guest1_cnic', 30)->nullable();
            $table->string('guest1_contact_no', 30)->nullable();
            $table->string('guest2_name')->nullable();
            $table->string('guest2_cnic', 30)->nullable();
            $table->string('guest2_contact_no', 30)->nullable();

            // Dynamic Professional Examination Distinctions & Positions
            $table->json('positions_data')->nullable();
            $table->text('positions_summary')->nullable();

            $table->string('status', 30)->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_registrations');
    }
};

