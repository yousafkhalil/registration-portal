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
        Schema::table('student_registrations', function (Blueprint $table) {
            $table->foreignId('verified_by_user_id')->nullable()->constrained('users')->nullOnDelete()->after('payment_remarks');
            $table->timestamp('verified_at')->nullable()->after('verified_by_user_id');
            $table->text('rejection_reason')->nullable()->after('verified_at');
            $table->text('admin_notes')->nullable()->after('rejection_reason');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_registrations', function (Blueprint $table) {
            $table->dropForeign(['verified_by_user_id']);
            $table->dropColumn([
                'verified_by_user_id',
                'verified_at',
                'rejection_reason',
                'admin_notes',
            ]);
        });
    }
};

