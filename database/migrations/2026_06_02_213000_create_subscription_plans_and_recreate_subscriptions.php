<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 15, 2)->default(0);
            $table->integer('duration_days')->default(0); // 0 means unlimited
            $table->text('description')->nullable();
            $table->text('features')->nullable(); // stored as JSON or delimited string
            $table->timestamps();
        });

        // Drop old subscriptions table to recreate it relationally
        Schema::dropIfExists('subscriptions');

        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('plan_id')->constrained('subscription_plans')->onDelete('cascade');
            $table->enum('status', ['pending', 'active', 'expired', 'rejected'])->default('pending');
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->string('payment_proof')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
        Schema::dropIfExists('subscription_plans');
    }
};
