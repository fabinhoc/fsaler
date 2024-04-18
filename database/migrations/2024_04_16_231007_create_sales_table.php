<?php

use App\Enums\OrderStatusEnum;
use App\Enums\SaleStatusEnum;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->foreignId('payment_type_id')->nullable()->constrained()->nullOnDelete();
            $table->date('payment_date')->nullable();
            $table->decimal('total')->default(0);
            $table->decimal('discount')->nullable()->default(0);
            $table->text('description')->nullable();
            $table->decimal('total_paid')->nullable()->default(0);
            $table->boolean('is_paid')->nullable()->default(false);
            $table->string('status')->default(OrderStatusEnum::AWAITING_CONFIRMATION);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
