<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
      Schema::create('church_member_department', function (Blueprint $table) {
            $table->id();

            $table->foreignId('church_member_id')
                ->constrained('church_members')
                ->onDelete('cascade');

            $table->foreignId('department_id')
                ->constrained('church_departments')
                ->onDelete('cascade');

            $table->foreignId('designation_id')
                ->nullable()
                ->constrained('church_designations')
                ->onDelete('set null');

            $table->unsignedBigInteger('workspace')->nullable();
            $table->unsignedBigInteger('created_by')->default(0);

            $table->timestamps();

            $table->unique(['church_member_id', 'department_id', 'designation_id'], 'member_department_designation_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('church_member_department');
    }
};
