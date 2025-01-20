<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniqueConstraintToTeacherCourseAssignments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teacher_course_assignments', function (Blueprint $table) {
            // Add a unique constraint to teacher_id and course_id
            $table->unique(['teacher_id', 'course_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teacher_course_assignments', function (Blueprint $table) {
            // Drop the unique constraint
            $table->dropUnique(['teacher_id', 'course_id']);
        });
    }
}
