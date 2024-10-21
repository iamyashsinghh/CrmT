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
        Schema::create('vendors_wallets', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('paid_by');
            $table->string('msg');
            $table->integer('ammount');
            $table->string('payment_proof');
            $table->string('payment_type');
            $table->integer('is_approved');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors_wallets');
    }
};
