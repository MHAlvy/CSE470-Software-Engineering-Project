<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('delivery_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donation_id')->constrained('donation_items')->onDelete('cascade');
            $table->foreignId('volunteer_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('status')->default('Pending');
            $table->timestamp('pickedUpAt')->nullable();
            $table->timestamp('deliveredAt')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('delivery_tasks');
    }
};
