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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('email', 255);
            $table->string('address', 255)->nullable();
            $table->string('state', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('zip', 255)->nullable();
            $table->string('country', 255)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('funnel_name', 255)->nullable();
            $table->string('funnel_step', 255)->default('step1');
            $table->string('product_asin', 255)->nullable();
            $table->integer('contacted')->default(0);
            $table->string('note')->nullable();
            $table->integer('status')->default(1);
            $table->string('shopify_customer_id', 191)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });              
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
