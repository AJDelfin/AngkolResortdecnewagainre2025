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
        Schema::create('financial_report_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('financial_report_id')->constrained()->onDelete('cascade');
            $table->string('description');
            $table->enum('type', ['revenue', 'expense']);
            $table->decimal('amount', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_report_items');
    }
};
