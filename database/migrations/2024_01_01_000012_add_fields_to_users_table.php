<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('company_id')->nullable()->after('id')->constrained('companies')->onDelete('set null');
            $table->string('phone', 20)->nullable()->after('email');
            $table->string('position')->nullable()->after('phone');
            $table->boolean('is_active')->default(true)->after('position');

            // Registration approval workflow
            $table->string('approval_status')->default('approved')->after('is_active');
            $table->foreignId('approved_by')->nullable()->after('approval_status')->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable()->after('approved_by');
            $table->foreignId('rejected_by')->nullable()->after('approved_at')->constrained('users')->onDelete('set null');
            $table->timestamp('rejected_at')->nullable()->after('rejected_by');
            $table->text('rejection_reason')->nullable()->after('rejected_at');

            $table->index('company_id');
            $table->index('is_active');
            $table->index('approval_status');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropForeign(['approved_by']);
            $table->dropForeign(['rejected_by']);
            $table->dropIndex(['approval_status']);
            $table->dropColumn([
                'company_id', 'phone', 'position', 'is_active',
                'approval_status', 'approved_by', 'approved_at',
                'rejected_by', 'rejected_at', 'rejection_reason',
            ]);
        });
    }
};
