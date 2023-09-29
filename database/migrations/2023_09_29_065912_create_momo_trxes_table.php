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
        Schema::create('momo_trxes', function (Blueprint $table) {
            $table->id();
            $table->string('transactionId');
            $table->double('amount', 10,2)->default(0);
            $table->string('number')->nullable();
            $table->string('externalId')->nullable();
            $table->text('response')->nullable();
            $table->text('details')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('momo_trxes');
    }
};
