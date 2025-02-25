<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEducationalHistoriesTable extends Migration
{
    public function up()
    {
        Schema::create('educational_histories', function (Blueprint $table) {
            $table->id();
            $table->string('user_id', 5);  // Ensure user_id matches format in users table
            $table->string('school_name');
            $table->string('education_level'); // 'Junior High', 'Senior High', 'Tertiary'
            $table->date('start_year')->nullable();
            $table->date('end_year')->nullable();
            $table->string('graduation_status'); // 'Completed', 'Not Completed'
            $table->string('track_strand')->nullable(); // For Senior High
            $table->string('program')->nullable(); // For College

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('educational_histories');
    }
}

