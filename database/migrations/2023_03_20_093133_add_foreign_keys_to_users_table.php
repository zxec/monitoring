<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('department_id')->nullable();
            $table->foreignId('position_id')->nullable();
            $table->foreignId('status_id')->nullable();
            $table->foreignId('gender_id')->nullable();

            $table->foreign('department_id')
                ->references('id')
                ->on('departments')
                ->onDelete('set null');
            $table->foreign('position_id')
                ->references('id')
                ->on('positions')
                ->onDelete('set null');
            $table->foreign('status_id')
                ->references('id')
                ->on('statuses')
                ->onDelete('set null');
            $table->foreign('gender_id')
                ->references('id')
                ->on('genders')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('department_id');
            $table->dropColumn('position_id');
            $table->dropColumn('status_id');
            $table->dropColumn('gender_id');
        });
    }
};
