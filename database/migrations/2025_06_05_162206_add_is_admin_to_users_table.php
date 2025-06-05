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
                        $table->dropUnique('users_email_unique');
                        $table->string('email', 191)->change();
                        $table->unique('email');


            $table->string('username')->unique()->after('email');
            $table->boolean('is_admin')->default(false)->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique('users_email_unique');
            $table->string('email', 255)->change();
            $table->unique('email');
            
            $table->dropColumn('username');
            $table->dropColumn('is_admin');
        });
    }
};
