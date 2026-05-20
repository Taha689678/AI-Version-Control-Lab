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
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            // Using Enrollment ID as per original design is fine, 
            // BUT looking at the Model, it belongsTo Enrollment.
            // However, linking directly to Student/Course is often more robust for queries,
            // but let's stick to Enrollment ID if the Model uses it to avoid breaking changes there.
            // WAIT - Logic check: 
            // The Grade model fillable uses 'enrollment_id'.
            // The Attendance model fillable uses 'student_id', 'course_id'.
            // So we must respect that.
            
            $table->unsignedBigInteger('enrollment_id');
            $table->foreign('enrollment_id')->references('id')->on('enrollments')->onDelete('cascade');
            
            $table->string('assessment_name'); // e.g., "Midterm"
            $table->decimal('score', 5, 2);
            $table->decimal('max_score', 5, 2)->default(100.00);
            $table->text('feedback')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
