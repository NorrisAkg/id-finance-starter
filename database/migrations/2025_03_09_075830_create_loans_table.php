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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->float('amount', 2);
            $table->string('reason')->nullable();
            $table->string('rib_code');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->integer('code_verified_count')->default(0);
            $table->foreignId('user_id')->constrained('users');
            $table->string('code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
