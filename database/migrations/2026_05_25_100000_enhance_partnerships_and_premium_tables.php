<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('partnerships', function (Blueprint $table) {
            $table->string('workflow_stage')->nullable()->after('status');
            $table->decimal('total_nilai_kontrak', 15, 2)->nullable()->after('workflow_stage');
            $table->string('file_kontrak')->nullable()->after('total_nilai_kontrak');
            $table->unsignedTinyInteger('rating')->nullable()->after('file_kontrak');
            $table->text('review')->nullable()->after('rating');
            $table->timestamp('rated_at')->nullable()->after('review');
            $table->timestamp('completed_at')->nullable()->after('rated_at');
        });

        Schema::create('partnership_timeline_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partnership_id')->constrained()->cascadeOnDelete();
            $table->string('stage');
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('partnership_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partnership_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('quantity_kg');
            $table->date('transaction_date');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('partnership_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partnership_id')->constrained()->cascadeOnDelete();
            $table->string('type');
            $table->string('file_path');
            $table->string('original_name');
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('premium_expires_at')->nullable()->after('account_tier');
            $table->string('verification_status')->default('none')->after('premium_expires_at');
            $table->string('verification_document_path')->nullable()->after('verification_status');
            $table->string('phone')->nullable()->after('email');
        });

        DB::table('partnerships')->where('status', 'accepted')->update([
            'status' => 'active',
            'workflow_stage' => 'negotiation',
        ]);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['premium_expires_at', 'verification_status', 'verification_document_path', 'phone']);
        });

        Schema::dropIfExists('partnership_documents');
        Schema::dropIfExists('partnership_transactions');
        Schema::dropIfExists('partnership_timeline_events');

        Schema::table('partnerships', function (Blueprint $table) {
            $table->dropColumn([
                'workflow_stage',
                'total_nilai_kontrak',
                'file_kontrak',
                'rating',
                'review',
                'rated_at',
                'completed_at',
            ]);
        });
    }
};
