<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained()->onDelete('cascade'); // Relasi -> quizzes
            $table->text('question'); // Soal
            $table->string('correct'); // Jawaban yang benar ('A', 'B', 'C', 'D')
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('questions');
    }

};
