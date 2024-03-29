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
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // Basic user information
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->date('dob');
            $table->enum('gender', ['male', 'female']);
            $table->string('bio')->nullable();
            $table->string('location')->nullable();

            // status
            $table->integer('followers_count')->default(0);
            $table->integer('following_count')->default(0);

            $table->rememberToken();
            $table->timestamp('last_login_at')->useCurrent();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
