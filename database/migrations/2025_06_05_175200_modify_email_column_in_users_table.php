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
                        $table->string('email', 191)->unique()->change();
        });
        // Contoh dari create_users_table.php
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique(); // <--- Ini yang membuat index users_email_unique
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            // $table->string('username')->unique(); // Jika Anda menambahkan username
            // $table->boolean('is_admin')->default(false); // Jika Anda menambahkan is_admin
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'email')) { 
                try {
                    $table->dropUnique('users_email_unique');
                } catch (\Exception $e) {
                    Log::warning("Could not drop unique index on email: " . $e->getMessage());
                }
                $table->string('email', 255)->change();
            }
        });
    }
};
