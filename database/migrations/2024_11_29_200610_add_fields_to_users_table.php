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
        Schema::table('users', function (Blueprint $table) {
          $table->string('last_name')->after('name')->nullable();
          $table->string('dni')->unique();
          $table->string('nickname')->unique();
          $table->enum('status', ['pending_validation', 'validated'])->default('pending_validation');
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::getConnection()->getDriverName() !== 'sqlite') {
                $table->dropColumn(['last_name', 'nickname', 'status']);
            }
        });
    }
};