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
        Schema::table('item_orders', function (Blueprint $table) {
            $table->foreignId('person_id')->constrained('people')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('item_orders', function (Blueprint $table) {
            $table->dropConstrainedForeignId('person_id');
        });
    }
};
