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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('package_id')->constrained();
            $table->string('order_id');
            $table->string('status');
            $table->string('message');
            $table->string('phone');
            $table->integer('amount');
            $table->integer('original_price'); //amount Charged
            $table->integer('profit');
            $table->string('data_plan')->nullable();
            $table->string('cable_tv')->nullable();
            $table->string('subscription_plan')->nullable();
            $table->string('smartcard_number')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
