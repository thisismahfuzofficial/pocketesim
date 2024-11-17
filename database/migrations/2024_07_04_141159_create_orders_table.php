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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('planID');
            $table->json('plan_information');
            $table->text('order_info')->nullable();
            $table->integer('quantity');
            $table->string('api');
            $table->string('payment_intent_id');
            $table->tinyInteger('status')->default(0);
            $table->integer('tax')->default(0);
            $table->integer('subtotal')->default(0);
            $table->integer('total')->default(0);
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
