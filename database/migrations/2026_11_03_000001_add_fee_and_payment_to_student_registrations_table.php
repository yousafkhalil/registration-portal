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
            $table->string('challan_no', 60)->nullable()->unique()->after('positions_summary');
            $table->decimal('fee_amount', 10, 2)->default(15000.00)->after('challan_no');
            $table->string('payment_status', 30)->default('unpaid')->after('fee_amount'); // unpaid, pending_verification, paid
            $table->string('payment_method', 30)->nullable()->after('payment_status'); // bank_deposit, online
            $table->decimal('paid_amount', 10, 2)->nullable()->after('payment_method');
            $table->timestamp('paid_at')->nullable()->after('paid_amount');
            $table->string('bank_name', 100)->nullable()->after('paid_at');
            $table->string('transaction_id', 100)->nullable()->after('bank_name');
            $table->string('receipt_path')->nullable()->after('transaction_id');
            $table->text('payment_remarks')->nullable()->after('receipt_path');
            $table->date('due_date')->nullable()->after('payment_remarks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_registrations', function (Blueprint $table) {
            $table->dropColumn([
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
            ]);
        });
    }
};

