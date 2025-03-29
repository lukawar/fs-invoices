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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('number', 20)->unique()->index()->nullable(false);
            $table->string('seller_nip')->index()->nullable(false);
            $table->string('buyer_nip')->index()->nullable(false);
            $table->string('product_name')->index()->nullable(false);
            $table->float('product_price')->nullable(false);
            $table->smallInteger('amount')->nullable(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
