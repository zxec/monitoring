<?php

use App\Models\Monitoring\Monitoring;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('entrances', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Monitoring::class)->constrained();
            $table->integer('number');
            $table->integer('floor');
            $table->unsignedInteger('sticker');
            $table->boolean('competitor')->comment('Наличие конкурента');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entrances');
    }
};
