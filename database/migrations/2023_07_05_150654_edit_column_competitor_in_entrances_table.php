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
        Schema::table('entrances', function (Blueprint $table) {
            $table->boolean('competitor')->default(0)->comment('Наличие конкурента')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entrances', function (Blueprint $table) {
            $table->boolean('competitor')->comment('Наличие конкурента')->change();
        });
    }
};
